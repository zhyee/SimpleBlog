<?php

/**
 * 图集文章模型
 */
namespace common\models;

use common\models\Article;

class ThumbArticle extends Article
{

    /**
     * 关联文章和图集
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getThumbs()
    {
        return $this->hasMany(ArticleThumb::className(), ['aid' => 'id'])
            ->asArray()
            ->all();
    }

}