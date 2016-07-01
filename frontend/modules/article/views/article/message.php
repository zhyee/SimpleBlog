<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/20
 * Time: 22:44
 */

use yii\bootstrap\Alert;

if( Yii::$app->session->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->session->getFlash('success'), //消息体
    ]);
}
if( Yii::$app->session->hasFlash('error') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-error',
        ],
        'body' => Yii::$app->session->getFlash('error'),
    ]);
}
?>

<a class="btn btn-link" href="javascript:history.go(-1);">返回</a>