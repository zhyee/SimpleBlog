<?php
/**
 * 文章标签
 */


namespace common\models;

class ArticleTag extends BaseActiveRecord
{
    public static function tableName()
    {
        return 'article_tag';
    }
}