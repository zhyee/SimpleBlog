<?php
/**
 * Yii bootstrap file.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

require(__DIR__ . '/BaseYii.php');

/**
 * Yii is a helper class serving common framework functionalities.
 *
 * It extends from [[\yii\BaseYii]] which provides the actual implementation.
 * By writing your own Yii class, you can customize some functionalities of [[\yii\BaseYii]].
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Yii extends \yii\BaseYii
{
    /**
     * @const   通信密钥
     */
    const SECRECT_KEY = 'yah^92j2dJHAJH*)#)!@!)MDS';

    /**
     * 利用curl上传文件到独立服务器
     * @param $file     文件路径
     * @param $apiServer        远程接口
     * @param null $width       生成图片的宽度
     * @param null $height      生成图片的高度
     * @return mixed            返回图片的url
     * @throws Exception
     */
    public static function uploadFile($file, $uploadServer, $width = NULL, $height = NULL){
        if(!function_exists('curl_init')){
            throw new Exception('未安装curl扩展');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadServer);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        $postFields = [
            'upfile' => '@' . realpath($file)
        ];
        $timeStamp = time();
        $postFields['timestamp'] = $timeStamp;
        $postFields['token'] = md5(self::SECRECT_KEY . $timeStamp);
        if($width !== NULL){
            $postFields['width'] = $width;
        }
        if($height !== NULL){
            $postFields['height'] = $height;
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        if($response['err_code']){
            throw new Exception($response['msg']);
        }

        return $response['url'];
    }
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require(__DIR__ . '/classes.php');
Yii::$container = new yii\di\Container();
