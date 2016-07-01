<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/6 0006
 * Time: 18:41
 */

namespace common\helpers;

class CoreHelper{

    /**
     * 返回零填充后的数字
     * @param $number
     * @param int $length
     */
    public static function zeroFill($number, $length = 5)
    {
        if(mb_strlen($number, \Yii::$app->charset) >= $length){
            return $number;
        }
        $count = $length - mb_strlen($number, \Yii::$app->charset);
        return str_repeat('0', $count) . $number;
    }

    /**
     * 格式化时间戳
     * @param $timestamp
     */
    public static function formatTimestamp($timestamp)
    {
        $timestamp = (int)$timestamp;
        $date = date('Ymd', $timestamp);
        if($date == date('Ymd')){
            $date = '今天';
        }elseif($date == date('Ymd', strtotime('-1 day'))){
            $date = '昨天';
        }else{
            $date = date('m月d日', $timestamp);
        }

        return $date . date('H:i', $timestamp);
    }
}