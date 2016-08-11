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

    public function rules()
    {
        return [
            [['aid', 'tid', 'tname'], 'required'],
            [['id', 'aid', 'tid'], 'integer'],
            ['tname', 'string', 'max' => 16]
        ];
    }
}