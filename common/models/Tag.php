<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25 0025
 * Time: 10:39
 */
namespace common\models;
use yii\data\Pagination;

class Tag extends BaseActiveRecord
{

    public static function tableName(){
        return 'tag';
    }

    public function rules()
    {
        return [
            [['name', 'usecount', 'addtime'], 'required'],
            ['name', 'string', 'max' => 16],
            [['id', 'usecount', 'addtime'], 'integer']
        ];
    }

    /**
     * 关联标签和文章标签表
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTag(){
        return $this->hasMany(ArticleTag::className(), ['tid' => 'id']);
    }

    /**
     *  获取标签下的文章
     * @param Pagination|NULL $pagination
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getArticles(pagination $pagination = NULL){
        $articleTable = Article::tableName();
        if($pagination){
            return $this->hasMany(Article::className(), ['id' => 'aid'])
                ->via('articleTag')
                ->where(["{$articleTable}.is_del" => 0])
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }else{
            return $this->hasMany(Article::className(), ['id' => 'aid'])
                ->via('articleTag')
                ->where(["{$articleTable}.is_del" => 0])
                ->all();
        }
    }

    /**
     * 获取标签下的文章数目
     */
    public function getArticlesCount(){
        $articleTable = Article::tableName();
        return $this->hasMany(Article::className(), ['id' => 'aid'])
            ->via('articleTag')
            ->where(["{$articleTable}.is_del" => 0])
            ->count();
    }

    /**
     * 添加tag标签
     * @param array $tags
     * @return boolean
     */
    public static function add(array $tags){
        //查找所有已存在的tag标签，把引用数加1
        $tagARs = self::find()->where(['in', 'name', $tags])->all();
        $existTags = [];
        foreach($tagARs as $tagAR){
            if (!$tagAR->updateCounters(['usecount' => 1]))
            {
                return FALSE;
            }
            $existTags[] = $tagAR->name;
        }
        //  数据库中不存在的新标签
        $notExistTags = array_diff($tags, $existTags);
        foreach($notExistTags as $tag){
            $tagObj = new self();
            $tagObj->attributes = [
                'name' => $tag,
                'usecount' => 1,
                'addtime' => time()
            ];
            if (!$tagObj->save())
            {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * 根据标签名称获取标签
     * @param $tagname
     * @return null|static
     */
    public static function findByTagname($tagname){
        return self::findOne(['tagname' => $tagname]);
    }

}