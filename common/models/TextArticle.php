<?php
namespace common\models;

class TextArticle extends Article
{

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [[['content'], 'string']]);
    }

    /**
     * 关联文章和正文
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getContent()
    {
        $content = $this->hasOne(ArticleContent::className(), ['aid' => 'id'])
            ->one();

        if (NULL === $content)
        {
            return NULL;
        }

        return $content->content;
    }


}