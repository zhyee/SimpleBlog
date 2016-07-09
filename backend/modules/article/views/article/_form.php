<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FormAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

FormAsset::register($this);
?>

<script>
    var _csrf = '<?= Yii::$app->request->csrfToken ?>';
    var uploadUrl = '<?= Url::to(['article/upload']) ?>';
</script>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inputTags')->textInput(['maxlength' => true])->hint("最多设置5个标签，超过5个会被忽略，每个标签最多6个字符，多个标签之间用空格分隔") ?>

    <?= $form->field($model, 'thumbnail')->fileInput() ?>

    <div class="form-group">
        <label class="control-label" for="article-thumb">图集</label>
        <input type="file" id="article-thumb">
    </div>

    <div id="thumbs">
    </div>

    <?= $form->field($model, 'content')->textarea(['rows' => 20, 'id' => 'ueditor']) ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' =>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .uploadify-button{
        background-color: #fff;
        background-image: -webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0, #dedede),
            color-stop(1, #fff)
        );
        border: none;
        padding: 0;
    }
    .uploadify:hover .uploadify-button{
        background-color: #fff;
        background-image: -webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0, #c3c3c3),
            color-stop(1, #fff)
        );
    }

    .fa-trash-o.delete{
        cursor: pointer;
    }


</style>


<?php


$script = <<<EOT

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
            buttonText      : '<i style="line-height: 30px" class="fa fa-plus fa-2x text-success"></i>',
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
            buttonText      : '<i style="line-height: 30px" class="fa fa-plus fa-2x text-success"></i>',
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
            html += '<label class="control-label col-md-2 col-xs-3 text-center">图片描述</label>';
            html += '<div class="col-md-8 col-xs-6">';
            html += '<input class="form-control" type="text" name="Article[thumb-description][]">';
            html += '</div>';
            html += '<div class="col-md-1 col-xs-1">';
            html += '<i class="fa fa-trash-o fa-2x delete text-success" title="删除"></i>';
            html += '<input type="hidden" name="Article[thumb-url][]" value="' + data.url + '">';
            html += '</div>';

            $(html).appendTo('#thumbs');
        }
    }
}
        });

        $(document).on('mouseover', '.fa-trash-o', function () {
            $(this).removeClass('text-success').addClass('text-info');
        });

        $(document).on('mouseout', '.fa-trash-o', function () {
            $(this).removeClass('text-info').addClass('text-success');
        });

        $(document).on('click', '.fa-trash-o', function() {
            $(this).closest('.form-group').remove();
        });

EOT;

    $this->registerJs($script);
?>
