<?php

namespace common\models;

use commmon\models\Thumb;
use SplObserver;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $title
 * @property string $author
 * @property string $content
 * @property string $publish_time
 */
class Article extends BaseActiveRecord implements \SplSubject
{
    private $observers;

    public function init()
    {
        parent::init();
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        if(!$this->observers->contains($observer)){
            $this->observers->attach($observer);
        }
    }

    public function detach(SplObserver $observer)
    {

    }

    public function notify()
    {

    }

    /**
     * 文章简介长度
     */
    const DESCRIPTION_LENGTH = 200;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    public $inputTags;    //用户输入的标签字符串

    /**
     * 关联文章和标签
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getTags(){
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable(TagIndex::tableName(), ['article_id' => 'id'])
            ->asArray()
            ->all();
    }

    /**
     * 关联文章和图集
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getThumbs() {
        return $this->hasMany(Thumb::className(), ['aid' => 'id'])
            ->asArray()
            ->all();
    }

    /**
     * 生成时间字符串 格式：2016年1月8日星期五上午10点33分
     */
    public function getTimeStr(){
        $time = $this->publish_time;
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
            [['title','content'], 'required'],
            [['content'], 'string'],
            [['publish_time'], 'integer'],
            [['description'], 'string', 'max' => 200],
            [['thumbnail'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 60],
            [['author'], 'string', 'max' => 16]
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
            'author' => '作者',
            'content' => '内容',
            'publish_time' => '发布时间',
            'inputTags' => '标签',
            'thumbnail' => '缩略图'
        ];
    }

    /**
     * 设置文章简介
     * @param null $description
     */
    public function setDescription($description = NULL){
        $description = $description === NULL ? $this->content : $description;
        $this->description = mb_substr(strip_tags($description), 0, self::DESCRIPTION_LENGTH, Yii::$app->charset);
    }

    /**
     * 初始化文章的一些属性
     */
    public function preSave(){
        $this->publish_time = time();
        $this->setDescription();
        $this->author = Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username;
    }

    /**
     * 删除与该篇文章相关联的标签
     */
    public function removeTags(){
        $articleId = $this->getAttribute('id');
        if(!$articleId){
            throw new InvalidParamException('文章ID参数不正确');
        }
        //删除与该篇文章相关联的标签
        TagIndex::deleteAll(['article_id' => $articleId]);
    }

    /**
     * @param int $value  1增加计数 -1减少计数
     */
    public function updateTagCount($value = 1){
        $articleId = $this->getAttribute('id');
        if(!$articleId){
            throw new InvalidParamException('文章ID参数不正确');
        }

        //更新标签引用计数
        $tags = $this->getTags();
        $tagIds = ArrayHelper::getColumn($tags, 'id');
        $value = (int)$value;
        Tag::updateAllCounters(['usecount' => $value], ['in', 'id', $tagIds]);
    }

    /**
     * 添加文章
     * @param $data
     * @param bool $isUpdate  是否是更新文章
     * @return bool
     * @throws \yii\db\Exception
     */
    public function add($data, $isUpdate = false){
        $trans_flag = true;
        $trans = self::getDb()->beginTransaction();    //开启事务

        if($isUpdate && !$this->thumbnail){
            unset($this->thumbnail);
        }

        if(!$this->save()){
            $trans_flag = FALSE;
            goto trans_end;
        }

        if($isUpdate){
            $this->removeTags();
            $this->updateTagCount(-1);
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
        $thumbDecriptions = $data['thumb-description'];
        $thumbUrls = $data['thumb-url'];

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
        if($trans_flag){
            $trans->commit();
        }else{
            $trans->rollBack();
        }
        return $trans_flag;
    }

    /**
     * 删除文章
     */
    public function delete(){
        $this->updateTagCount(-1);    //删除关联标签和引用计数
        $this->is_del = 1;
        $this->del_time = time();
        return $this->save();
    }
}
