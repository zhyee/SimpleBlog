<?php
/**
 * Created by PhpStorm.
 * User: Administrator

 * Date: 2016/7/4
 * Time: 23:58
 */

namespace common\models;

class ArticleThumb extends BaseActiveRecord {

    /**
     * 返回模型对应的表名
     * @return string
     */
    public static function tableName() {
        return 'article_thumb';
    }

    public function rules()
    {
        return [
              
        ];
    }

}