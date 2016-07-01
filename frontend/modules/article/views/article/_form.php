<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\ArticleAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
ArticleAsset::register($this);
?>

<script>
    var _csrf = '<?= Yii::$app->request->csrfToken ?>';
</script>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inputTags')->textInput(['maxlength' => true])->hint("最多设置5个标签，超过5个会被忽略，每个标签最多6个字符，多个标签之间用空格分隔") ?>

    <?= $form->field($model, 'thumbnail')->fileInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 20, 'id' => 'ueditor']) ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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