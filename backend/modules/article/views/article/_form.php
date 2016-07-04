<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ArticleAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
ArticleAsset::register($this);
?>

<script>
    var _csrf = '<?= Yii::$app->request->csrfToken ?>';
    var uploadUrl = '<?= Url::to(['article/upload']) ?>';
</script>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inputTags')->textInput(['maxlength' => true])->hint("最多设置5个标签，超过5个会被忽略，每个标签最多6个字符，多个标签之间用空格分隔") ?>

    <?= $form->field($model, 'thumbnail')->fileInput() ?>

    <div class="form-group">
        <label class="control-label" for="article-thumb">图集</label>
        <input type="file" id="article-thumb" name="Article[thumb]">
    </div>

    <div id="thumbs">
        <div class="form-group">
            <div class="col-md-2">
                <img src="http://img.zyee.org/20160629/14/294557736b516c346.jpg" class="img-responsive">
            </div>
            <label class="control-label col-md-2 text-center">图片描述</label>
            <div class=" col-md-8">
                <input class="form-control" type="text" name="thumb-tip[]" >
            </div>
            <input type="hidden" name="thumb[]" value="http://img.zyee.org/20160629/14/294557736b516c346.jpg">
        </div>
    </div>

    <?= $form->field($model, 'content')->textarea(['rows' => 20, 'id' => 'ueditor']) ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' =>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .uploadify-button{
        background-color: transparent;
        border: none;
        padding: 0;
    }
    .uploadify:hover .uploadify-button{
        background-color: transparent;
    }
</style>

<script>

    window.onload = function() {

        var um = UM.getEditor('ueditor', {
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            initialFrameWidth: 'auto',
            initialFrameHeight: 280,
            imageUrl : 'index.php?r=article/upload'
        });

        $('#article-thumbnail').uploadify({
            width           : 30,
            heigth          : 30,
            fileSizeLimit   : '2048KB',
            buttonText      : '',
            buttonImage     : '/back/images/attachment.png',
            swf             : '/back/css/uploadify.swf',
            uploader        : uploadUrl,
            formData        : {_csrf : _csrf},
            fileObjName     : 'upfile',
            onUploadSuccess : function(file, data, response){
                if(response){
                    var rs = $.parseJSON(data);
                    if(rs.err_code > 0){
                        alert(rs.msg);
                    }else{
                        var data = rs.data;
                        $('input[name="Article[thumbnail]"]').val(data.url);
                        $('.field-article-thumbnail').find('img').remove();
                        $('<img>').attr({src : data.url, width:80}).appendTo($('.field-article-thumbnail'))
                    }
                }
            }
        });


        $('#article-thumb').uploadify({
            width           : 30,
            height          : 30,
            fileSizeLimit   : '2048KB',
            buttonText      : '',
            buttonImage     : '/back/images/attachment.png',
            swf             : '/back/css/uploadify.swf',
            uploader        : uploadUrl,
            formData        : {_csrf : _csrf},
            fileObjName     : 'upfile',
            onUploadSuccess : function (file, data, response) {
                if(response) {
                    var rs = $.parseJSON(data);
                    if(rs.err_code > 0) {
                        alert(rs.msg);
                    } else {
                        var data = rs.data;
                        var html = '<div class="form-group">';
                        html += '<div class="col-md-1 col-xs-2">';
                        html += '<img src="' + data.url + '" height="38">';
                        html += '</div>';
                        html += '<label class="control-label col-md-2 col-xs-3">图片描述</label>';
                        html += '<div class="col-md-8 col-xs-6">';
                        html += '<input class="form-control" type="text" name="Article[thumb-description][]">';
                        html += '</div>';
                        html += '<div class="col-md-1 col-xs-1">';
                        html += '<i class="fa fa-trash-o"></i>';
                        html += '</div>';
                        html += '<input type="hidden" name="Article[thumb][]" value="' + data.url + '">';
                        html += '</div>';

                        $(html).appendTo('#thumbs');
                    }
                }

            }
        });

    }


</script>