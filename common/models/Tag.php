<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25 0025
 * Time: 10:39
 */
namespace common\models;
use yii\data\Pagination;

class Tag extends BaseActiveRecord{
    public static function tableName(){
        return 'tag';
    }

    /**
     * 获取标签下的文章
     */
    public function getArticles(pagination $pagination = NULL){
        if($pagination){
            return $this->hasMany(Article::className(), ['id' => 'article_id'])
                ->viaTable(TagIndex::tableName(), ['tag_id' => 'id'])
                ->where(['is_del' => 0])
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }else{
            return $this->hasMany(Article::className(), ['id' => 'article_id'])
                ->viaTable(TagIndex::tableName(), ['tag_id' => 'id'])
                ->where(['is_del' => 0])
                ->all();
        }
    }

    /**
     * 获取标签下的文章数目
     */
    public function getArticlesCount(){
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable(TagIndex::tableName(), ['tag_id' => 'id'])
            ->where(['is_del' => 0])
            ->count();
    }

    /**
     * 添加tag标签
     * @param array $tags
     */
    public static function add(array $tags){
        //查找所有已存在的tag标签，把引用数加1
        $tagARs = self::find()->where(['in', 'tagname', $tags])->indexBy('tagname')->all();
        foreach($tagARs as $tagAR){
            $tagAR->updateCounters(['usecount' => 1]);
        }
        $tags = array_diff($tags, array_keys($tagARs));
        //不存在的则新建
        foreach($tags as $tag){
            $tagObj = new self();
            $tagObj->tagname = $tag;
            $tagObj->usecount = 1;
            $tagObj->addtime = time();
            $tagObj->save();
        }
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