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

    <div class="form-group field-article-thumbnail">
        <label class="control-label" for="article-thumbnail">缩略图</label>
        <div>
            <input type="file" class="simple-uploader-file" id="article-thumbnail">
            <input type="hidden" name="Article[thumbnail]">
            <div class="help-block"></div>
        </div>
    </div>

    <div class="form-group field-article-thumb">
        <label class="control-label" for="article-thumb">图集</label>
        <input type="file" class="simple-uploader-file" id="article-thumb">

        <div class="help-block"></div>
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

    .fa-trash-o.delete{
        cursor: pointer;
    }


</style>

<script>

    $(function () {

        var um = UM.getEditor('ueditor', {
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            initialFrameWidth: 'auto',
            initialFrameHeight: 280,
            imageUrl : 'index.php?r=article/upload'
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



        $('#article-thumbnail').simpleUploader({
            debug : true,
            url : uploadUrl,
            buttonText : '<i class="fa fa-plus fa-lg"></i>',
            filePostName : 'upfile',
            extraFormData : {_csrf : _csrf},
            onUploadSuccess : function (responseText) {
                var result = $.parseJSON(responseText);
                if(result.err_code > 0){
                    alert(result.msg);
                }else{
                    var data = result.data;
                    $('input[name="Article[thumbnail]"]').val(data.url);
                    var o = $('.field-article-thumbnail');
                    o.find('img').remove();
                    $('<img>').attr({src : data.url, width:80}).appendTo(o);
                }
            }
        });

        $('#article-thumb').simpleUploader({
            debug : true,
            url : uploadUrl,
            buttonText : '<i class="fa fa-plus fa-lg"></i>',
            filePostName : 'upfile',
            extraFormData : {_csrf : _csrf},
            onUploadSuccess : function (responseText) {
                var rs = $.parseJSON(responseText);
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
        })

    });
</script>
