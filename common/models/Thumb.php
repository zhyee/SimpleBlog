<?php
/**
 * Created by PhpStorm.
 * User: Administrator

 * Date: 2016/7/4
 * Time: 23:58
 */

namespace commmon\models;

use common\models\BaseActiveRecord;

class Thumb extends BaseActiveRecord {

    /**
     * 返回模型对应的表名
     * @return string
     */
    public static function tableName() {
        return 'thumb';
    }

    public function add($thumbs) {

        foreach($thumbs as $thumb) {
            $model = new self();
            $model->aid = $thumb['aid'];
            $model->url = $thumb['url'];
            $model->description = $thumb['description'];
            $model->addtime = time();
            $model->is_del = 0;
            $model->save();
        }
    }

}