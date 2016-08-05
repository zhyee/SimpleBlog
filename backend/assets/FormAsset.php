<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 18:38
 */

namespace backend\assets;

use yii\web\AssetBundle;

class FormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'umeditor/themes/default/css/umeditor.css',
        'css/uploadify.css',
        'css/simple-uploader.css'
    ];

    public $js = [
        'umeditor/umeditor.config.js',
        'umeditor/umeditor.min.js',
        'umeditor/lang/zh-cn/zh-cn.js',
        'js/jquery.uploadify.min.js',
        'js/jquery.simpleuploader.js'
    ];

    public $depends = [
    ];
}

