<?php

namespace common\models;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use common\constants\ArticleConstant;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $title
 * @property string $author
 * @property string $content
 * @property string $addtime
 */
class Article extends BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * 关联文章和标签
     */
    public function getTag(){
        return $this->hasMany(ArticleTag::className(), ['aid' => 'id'])->asArray();
    }


    /**
     * 生成时间字符串 格式：2016年1月8日星期五上午10点33分
     */
    public function getTimeStr(){
        $time = $this->addtime;
        $str = date('Y年m月d日', $time);
        $weekArr = ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
        $str .= $weekArr[date('w', $time)];
        $str .= date('H', $time) > 12 ? '下午' : '上午';
        $str .= date('10点33分', $time);
        return $str;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'addtime', 'author'], 'required'],
            ['title', 'string', 'max' => 60],
            ['type', 'in', 'range' => array_keys(Yii::$app->params['articleType'])],
            [['author'], 'string', 'max' => 16],
            [['thumbnail', 'description'], 'string', 'max' => 200],
            [['id', 'addtime', 'del_time'], 'integer'],
            ['is_del', 'in', 'range' => [0,1]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '文章标题',
            'type'  => '文章类型',
            'author' => '作者',
            'thumbnail' => '缩略图',
            'addtime' => '发布时间'
        ];
    }

    /**
     * 根据文章详情
     * @param $condition
     * @return null|static
     */
    public static function getDetail($condition)
    {
        $article = self::findOne($condition);
        if (NULL === $article)
        {
            return NULL;
        }

        $result = NULL;
        switch ($article->type)
        {
            case ArticleConstant::ARTICLE_TYPE_TEXT:
                $result = TextArticle::findOne($condition);
                break;
            case ArticleConstant::ARTICLE_TYPE_THUMB:
                $result = ThumbArticle::findOne($condition);
                break;
        }

        return $result;
    }


    /**
     * 删除与该篇文章相关联的标签
     */
    public function removeTags()
    {
        $id = $this->id;
        if(!$id){
            throw new InvalidParamException('文章ID参数不正确');
        }
        //删除与该篇文章相关联的标签
        ArticleTag::deleteAll(['aid' => $id]);
    }

    /**
     * @param int $value  1增加计数 -1减少计数
     */
    public function updateTagUsecount($value = 1)
    {
        if(!$this->id)
        {
            throw new InvalidParamException('文章ID参数不正确');
        }
        //更新标签引用计数
        $tagIds = ArrayHelper::getColumn($this->tag, 'tid');
        $value = (int)$value;
        Tag::updateAllCounters(['usecount' => $value], ['in', 'id', $tagIds]);
    }

    /**
     * 标签使用计数+1
     */
    public function increaseTagUsecount()
    {
        $this->updateTagUsecount(1);
    }

    /**
     * 标签使用计数-1
     */
    public function decreaseTagUsecount()
    {
        $this->updateTagUsecount(-1);
    }

    /**
     * 添加文章
     * @param $data
     * @param bool $isUpdate  是否是更新文章
     * @return bool
     * @throws \yii\db\Exception
     */
    public function add($data, $isUpdate = false)
    {
        $trans_flag = true;
        $trans = self::getDb()->beginTransaction();    //开启事务

        if($isUpdate && !$this->thumbnail){
            unset($this->thumbnail);
        }

        if(!$this->save())
        {
            $trans_flag = FALSE;
            goto trans_end;
        }

        if($isUpdate)
        {
            unset($this->addtime);
            $this->removeTags();
            $this->decreaseTagUsecount();
        }

        $tags = preg_replace('/ {2,}/', ' ', trim($data['inputTags']));    //多个连续空格替换成一个

        if($tags){
            $tags = explode(' ', $tags);
            $tags = array_unique(array_filter($tags));
            $tags = array_slice($tags, 0, 5);
            Tag::add($tags);
            $tagID = Tag::find()->select('id')->where(['tagname' => $tags])->asArray()->all();
            $tagID = ArrayHelper::getColumn($tagID, 'id');
            $dataArray = [];
            $articleId = $this->getAttribute('id');
            foreach($tagID as $id){
                $dataArray[] = [$articleId, $id];
            }
            $db = self::getDb();
            if(!$db->createCommand()->batchInsert('tagindex', ['article_id', 'tag_id'], $dataArray)->execute()){
                $trans_flag = FALSE;
                goto trans_end;
            }
        }

        //  图集信息
        $thumbDecriptions = isset($data['thumb-description']) ? $data['thumb-description'] : [];
        $thumbUrls = isset($data['thumb-url']) ? $data['thumb-url'] : [];

        $thumbData = [];
        $index = 0;
        if ($thumbUrls)
        {
            foreach ($thumbUrls as $k => $url)
            {
                $thumbData[$index]['aid'] = $this->getAttribute('id');
                $thumbData[$index]['url'] = $url;
                $thumbData[$index]['description'] = $thumbDecriptions[$k] ?: '';
                $thumbData[$index]['addtime'] = time();
                $thumbData[$index]['is_del'] = 0;
                $index++;
            }
            $db = self::getDb();

            if (!$db->createCommand()->batchInsert('thumb',
                ['aid', 'url', 'description', 'addtime', 'is_del'],
                $thumbData)
            ->execute())
            {
                $trans_flag = FALSE;
                goto trans_end;
            }
        }

        trans_end:
        if($trans_flag)
        {
            $trans->commit();
        }
        else
        {
            $trans->rollBack();
        }
        return $trans_flag;
    }

    /**
     * 删除文章
     */
    public function delete(){
        $this->decreaseTagUsecount();    //删除关联标签引用计数
        $this->is_del = 1;
        $this->del_time = time();
        return $this->save();
    }
}
