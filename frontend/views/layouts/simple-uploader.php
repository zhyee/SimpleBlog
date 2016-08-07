<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\BootstrapPluginAsset;
$actionId = Yii::$app->controller->action->id;

BootstrapPluginAsset::register($this);


$baseUrl = Yii::$app->urlManager->baseUrl;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?= $this->head() ?>

    <link rel="stylesheet" href="<?= $baseUrl ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/simple-uploader.css">

</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-inverse navbar-static-top container-fluid">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Url::to(['/simple-uploader/simple-uploader']) ?>">SimpleUploader</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?php if ($actionId == 'index' || $actionId == 'about'): ?>class="active"<?php endif; ?>><a href="<?= Url::to(['about']) ?>">About</a></li>
                <li <?php if ($actionId == 'docs'): ?>class="active"<?php endif; ?>><a href="<?= Url::to(['docs']) ?>">Docs</a></li>
                <li <?php if ($actionId == 'examples'): ?>class="active"<?php endif; ?>><a href="<?= Url::to(['examples']) ?>">Example</a></li>
            </ul>
        </div>
    </div>

</nav>

<main class="main-content">

    <div class="container">

        <?= $content ?>

    </div>

</main>


<footer>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="hidden-sm hidden-md hidden-lg col-xs-12">
                    <span>本站由Yii2 framework，BootStrap驱动</span>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <span class="hidden-xs">本站由Yii2 framework，BootStrap驱动</span>
                    <span>Copyright &copy; <a href="http://zyee.org">zyee.org</a></span> |
                    <span><a href="http://www.miibeian.gov.cn/" target="_blank">皖ICP备14016681号-2</a></span>
                </div>
            </div>
        </div>
    </div>
</footer>



<aside class="hidden-xs">
    <div class="sidebar">
        <ul>
            <li>
                <a href="<?= Url::home() ?>">
                    <dl>
                        <dt><i class="fa fa-lg fa-home"></i></dt>
                        <dd>首页</dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['/site/about']) ?>">
                    <dl>
                        <dt><i class="fa fa-lg fa-flag"></i></dt>
                        <dd>关于</dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['tag/index']) ?>">
                    <dl>
                        <dt><i class="fa fa-lg fa-tags"></i></dt>
                        <dd>标签</dd>
                    </dl>
                </a>
            </li>
            <li>
                <dl id="back-top">
                    <dt><i class="fa fa-lg fa-angle-up"></i></dt>
                    <dd>顶部</dd>
                </dl>
            </li>
        </ul>
    </div>
</aside>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>