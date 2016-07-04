<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4 0004
 * Time: 16:15
 */

namespace common\models;

class Thumb extends BaseActiveRecord {

    public static function tableName()
    {
        return 'thumb';
    }


    public function add(array $thumbs) {
        foreach($thumbs as $thumb) {
            $thumb = new static();
            $thumb->aid = $thumb['aid'];
            $thumb->title = $thumb['title'];
            $thumb->url = $thumb['url'];
            $thumb->description = $thumb['description'];
            $thumb->save();
        }
    }

}