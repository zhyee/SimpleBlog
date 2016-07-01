<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/22 0022
 * Time: 14:40
 */
namespace frontend\assets;

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
        'js/jquery.lazyload.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}