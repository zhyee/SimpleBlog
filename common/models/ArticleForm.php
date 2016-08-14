<?php
/**
 * 文章表单模型
 */

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\exceptions\ArticleException;
use common\constants\ArticleConstant;

class ArticleForm extends Model
{

    /**
     * 文章主键
     * @var integer
     */
    public $id;

    /**
     * 标题
     * @var string
     */
    public $title;

    /**
     * 文章类型
     * @var integer
     */
    public $type = ArticleConstant::ARTICLE_TYPE_TEXT;

    /**
     * 标签
     * @var string
     */
    public $tag;

    /**
     * 文章作者
     * @var string
     */
    public $author;


    /**
     * 文章缩略图
     * @var string
     */
    public $thumbnail;


    /**
     * 文章概要
     * @var string
     */
    public $description;

    /**
     * 添加时间
     * @var integer
     */
    public $addtime;

    /**
     * 是否被删除
     * @var integer
     */
    public $is_del;

    /**
     * 删除时间
     * @var integer
     */
    public $del_time;

    /**
     * 文章正文
     * @var string
     */
    public $content;


    /**
     * 文章图集集合
     * @var array
     */
    public $thumbUrl;


    /**
     * 文章图集描述集合
     * @var array
     */
    public $thumbDescription;

    /**
     * 文章图集图片添加时间集合
     * @var array
     */
    public $thumbAddtime;


    public function rules()
    {
        return [
            [['title', 'type', 'author', 'addtime'], 'required'],
            ['title', 'string', 'max' => 60],
            ['type', 'in', 'range' => array_keys(Yii::$app->params['articleType'])],
            ['tag', 'string'],
            ['author', 'string', 'max' => 16],
            ['thumbnail', 'string', 'max' => 200],
            ['description', 'string', 'max' => 200],
            ['content', 'string', 'max' => 65535],
            [['id', 'addtime', 'is_del', 'del_time'], 'integer'],
            [['thumbUrl', 'thumbDescription', 'thumbAddtime'], 'default', 'value' => []]
        ];
    }

    /**
     * 新增文章时初始化一些信息
     */
    public function beforeValidate()
    {
        if (!$this->id)
        {
            $this->author = Yii::$app->user->isGuest ?
                '' : Yii::$app->user->identity->username;
            $this->setDescription();
            $this->addtime = time();
            $this->is_del = 0;
            $this->del_time = 0;
        }

        return TRUE;
    }

    /**
     * 自动提取文章简介
     */
    private function setDescription()
    {
        switch ($this->type)
        {
            case ArticleConstant::ARTICLE_TYPE_TEXT:
                $this->description = $this->content ? mb_substr(html_entity_decode(strip_tags($this->content), ENT_QUOTES|ENT_HTML5), 0, ArticleConstant::DESCRIPTION_LENGTH, Yii::$app->charset) : '';
                break;
            case ArticleConstant::ARTICLE_TYPE_THUMB:
                break;
        }


    }

    public function attributeLabels()
    {
        return [
            'title' => '文章标题',
            'type'  => '文章类型',
            'tag' => '标签',
            'author' => '作者',
            'content' => '内容',
            'addtime' => '发布时间',
            'thumbnail' => '缩略图'
        ];
    }

    /**
     * 添加文章
     * @param $postData
     * @return boolean
     */
    public function add($postData){
        $this->load($postData);
        $transation = Yii::$app->getDb()->beginTransaction();
        try
        {
            if ($this->validate())
            {
                $article = new Article();
                $article->attributes = $this->attributes;

                Yii::error(print_r($this->attributes,true));

                if (!$article->save())
                {
                    throw new ArticleException('文章保存失败');
                }

                $this->id = $article->id;

                // 添加标签
                $tags = array_filter(array_map('trim', explode(' ', $this->tag)));

                Yii::error(print_r($tags, true));

                if (!Tag::add($tags))
                {
                    throw new ArticleException('保存标签失败');
                }

                $tagARs = Tag::find()->where(['in', 'name', $tags])->all();
                foreach($tagARs as $tagAR)
                {
                    $articleTag = new ArticleTag();
                    $articleTag->attributes = [
                        'aid' => $this->id,
                        'tid' => $tagAR->id,
                        'tname' => $tagAR->name
                    ];

                    if (!$articleTag->save())
                    {
                        throw new ArticleException('添加文章标签失败');
                    }
                }

                if ($this->type == ArticleConstant::ARTICLE_TYPE_TEXT)
                {
                    $articleContent = new ArticleContent();
                    $articleContent->attributes = [
                        'aid' => $this->id,
                        'content' => $this->content
                    ];

                    if (!$articleContent->save())
                    {
                        throw new ArticleException('文章内容保存失败');
                    }
                }
                elseif ($this->type === ArticleConstant::ARTICLE_TYPE_THUMB)
                {
                    if ($this->thumbUrl)
                    {
                        foreach ($this->thumbUrl as $index => $url)
                        {
                            $articleThumb = new ArticleThumb();
                            $articleThumb->attributes = [

                            ];
                        }
                    }
                }

                $transation->commit();
                return TRUE;
            }
            else
            {
                Yii::error(print_r($this->errors, true));
            }
        }
        catch (Exception $e)
        {
            $transation->rollBack();
            Yii::error($e->getMessage());
        }
        return FALSE;
    }

    /**
     * 修改文章
     */
    public function update()
    {

    }

    /**
     * @param $condition
     * @return null
     */
    public static function findOne($condition)
    {
        $model = new self();
        $article = Article::findOne($condition);
        if (NULL === $article)
        {
            return NULL;
        }

        $model->attributes = $article->attributes;

        //  标签
        $articleTags = ArticleTag::find()->where(['aid' => $article->id])
            ->asArray()->indexBy('id')->all();

        if (!$articleTags)
        {
            $model->tag = [];
        }
        else
        {
            $model->tag = implode(' ', ArrayHelper::getColumn($articleTags, 'tname', TRUE));
        }

        //  文章正文
        $articleContent = ArticleContent::findOne(['aid' => $article->id]);

        if (NULL === $articleContent)
        {
            $model->content = '';
        }
        else{
            $model->content = $articleContent->content;
        }

        //  图集
        $articleThumbs = ArticleThumb::find()
            ->where(['aid' => $article->id])
            ->asArray()->indexBy('id')->all();

        if (!$articleThumbs){
            $model->thumbUrl = [];
            $model->thumbDescription = [];
            $model->thumbAddtime = [];
        }
        else
        {
            $model->thumbUrl = ArrayHelper::getColumn($articleThumbs, 'url', TRUE);
            $model->thumbDescription = ArrayHelper::getColumn($articleThumbs, 'description', TRUE);
            $model->thumbAddtime = ArrayHelper::getColumn($articleThumbs, 'addtime', TRUE);
        }

        return $model;
    }
}