<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/13
 * Time: 22:30
 */
namespace common\models;
use yii\base\Model;

class EntryForm extends Model{
    public $name;
    public $email;

    public function rules(){
        return [
            [['name', 'email'], 'required'],
            ['email', 'email']
        ];
    }
}