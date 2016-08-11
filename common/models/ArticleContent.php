<?php

/**
 * 普通文章模型
 */
namespace common\models;

class ArticleContent extends BaseActiveRecord
{
    /**
     * 模型对应表名
     * @return string
     */
    public static function tableName()
    {
        return 'article_content';
    }

    public function rules()
    {
        return [
            ['aid', 'required'],
            [['id', 'aid'], 'integer'],
            ['content', 'string']
        ];
    }
}