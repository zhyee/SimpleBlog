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

    public $js = [
        'umeditor/umeditor.config.js',
        'umeditor/umeditor.min.js',
        'umeditor/lang/zh-cn/zh-cn.js',
        'js/jquery.uploadify.min.js'
    ];

    public $depends = [
    ];
}