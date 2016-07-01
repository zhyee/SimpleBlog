<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/22 0022
 * Time: 14:40
 */
namespace backend\assets;

use yii\web\AssetBundle;

class ArticleAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/uploadify.css',
        'umeditor/themes/default/css/umeditor.css'
    ];

    public $js = [
        'umeditor/umeditor.config.js',
        'umeditor/umeditor.min.js',
        'umeditor/lang/zh-cn/zh-cn.js',
        'js/jquery.uploadify.min.js',
        'js/init.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}