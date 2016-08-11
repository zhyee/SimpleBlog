<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FormAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

FormAsset::register($this);

$params = Yii::$app->params;
?>

<script>
    var _csrf = '<?= Yii::$app->request->csrfToken ?>';
    var uploadUrl = '<?= Url::to(['article/upload']) ?>';
</script>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if ($model->id): ?>
        <?= $form->field($model, 'type')->dropDownList($params['articleType'], ['disabled' => 'disabled']) ?>
    <?php else : ?>
        <?= $form->field($model, 'type')->dropDownList($params['articleType']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true])->hint("最多设置5个标签，超过5个会被忽略，每个标签最多6个字符，多个标签之间用空格分隔") ?>

    <div class="form-group field-article-thumbnail">
        <label class="control-label" for="article-thumbnail">缩略图</label>
        <div>
            <input type="file" id="article-thumbnail">
            <input type="hidden" name="Article[thumbnail]">
            <div class="help-block"></div>
        </div>
    </div>

    <div id="article-type-0">
        <?= $form->field($model, 'content')->textarea(['rows' => 20, 'id' => 'ueditor']) ?>
        <div class="form-group field-content-thumb">
            <label class="control-label">插入正文图片</label>
            <input type="file" id="content-thumb">
            <div id="thumb-list" class="mt-10"></div>
        </div>
    </div>

    <div class="hidden" id="article-type-1">
        <div class="form-group field-article-thumb">
            <label class="control-label" for="article-thumb">图集</label>
            <input type="file" id="article-thumb">
            <div class="help-block"></div>
        </div>
        <div id="thumbs"></div>
    </div>

    <div class="hidden" id="article-type-2"></div>

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
            initialFrameHeight: 280
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

        //  删除图片
        $(document).on('click', '.thumb-del', function () {
           $(this).closest('.row').remove();
        });

        //  插入图片
        $(document).on('click', '.thumb-insert', function () {
            var href = $(this).parent().prev().find('a').prop('href');
            var img = '<img src="' + href + '" class="img-responsive" >';
            um.execCommand('insertHtml', img);
        });

        //  切换文章类型
        $('#articleform-type').change(function () {
            $('div[id^="article-type-"]').addClass('hidden').filter('#article-type-' + $(this).val()).removeClass('hidden');
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
        });

        $('#content-thumb').simpleUploader({
            debug : true,
            url : uploadUrl,
            buttonText : '<i class="fa fa-plus fa-lg"></i>',
            filePostName : 'upfile',
            extraFormData : {_csrf : _csrf},
            onUploadSuccess : function (responseText) {
                var result = $.parseJSON(responseText);
                if (result.err_code > 0){
                    alert(result.msg);
                }
                else {
                    var data = result.data;
                    var html = '<div class="row mt-2">';
                    html += '<div class="col-md-8">';
                    html += '<a href="' + data.url + '" target="_blank">';
                    html += data.url;
                    html += '</a></div>';
                    html += '<div class="col-md-offset-1 col-md-3">';
                    html += ' <a href="javascript:;" class="thumb-insert">插入</a>';
                    html += '<a href="javascript:;" class="thumb-del ml-10">删除</a>';
                    html += '</div></div>';

                    $(html).appendTo('#thumb-list');
                }
            }
        });
    });
</script>
