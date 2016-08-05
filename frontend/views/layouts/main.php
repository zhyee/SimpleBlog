<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\widgets\LatestArticleWidget;
use common\widgets\TagCloudWidget;
use yii\helpers\Url;

$baseUrl = Yii::$app->urlManager->baseUrl;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title><?= Html::encode($this->title) ?></title>

    <meta name="HandheldFriendly" content="True" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= Html::csrfMetaTags() ?>

    <?= $this->head() ?>
    <link rel="shortcut icon" href="<?= $baseUrl ?>/images/favicon.ico">

    <link rel="stylesheet" href="<?= $baseUrl ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/vs.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/screen.css" />

    <script>
        var _hmt = _hmt || [];
    </script>

</head>

<body class="home-template">
<?php $this->beginBody() ?>

<!-- start header -->
<header class="main-header"  style="background-image: url(http://image.golaravel.com/5/c9/44e1c4e50d55159c65da6a41bc07e.jpg)"">
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>愿你做的所有事情 都是因为喜欢</h1>
        </div>
    </div>
</div>
</header>
<!-- end header -->

<?php
NavBar::begin([
    'options' => [
        'class' => 'main-navigation',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'menu'],
    'items' => [
        ['label' => '首页', 'url' => ['/article/article/index']],
        ['label' => '关于作者', 'url' => ['/site/about']],
    ],
]);

NavBar::end();
?>

<!-- start site's main content area -->
<section class="content-wrap">
    <div class="container">

        <div class="row">
            <main class="col-md-10 col-md-offset-1 main-content">

                <?= $content ?>

            </main>
        </div>

    </div>
</section>

<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">最新文章</h4>
                    <div class="content recent-post">
                        <?= LatestArticleWidget::widget() ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">标签云</h4>
                    <div class="content tag-cloud">

                        <?= TagCloudWidget::widget() ?>

                        <a title="更多" href="<?= Url::to(['/article/tag/index']) ?>">...</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">友情链接</h4>
                    <div class="content tag-cloud friend-links">

                        <a href="https://github.com/zhyee" title="GitHub主页"  target="_blank">GitHub主页</a>
                        <a href="http://blog.csdn.net/zhang197093" title="CSDN主页"  target="_blank">CSDN主页</a>
                        <a href="http://jingyan.baidu.com/user/npublic?un=zhang197093" title="百度经验主页" target="_blank">百度经验主页</a>

                        <hr>

                        <a href="http://www.haoju.cn" title="好居网" target="_blank">好居网</a>
                        <a href="http://www.goodid.com" title="智企ID"  target="_blank">智企ID</a>
                        <a href="http://www.ahwindow.cn" title="吉尔科技" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'gulpjscomcn'])" target="_blank">吉尔科技</a>
                        <a href="http://www.caijiruanjian.com" title="熊猫采集" target="_blank">熊猫采集</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


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

<script src="<?= $baseUrl ?>/js/jquery.fitvids.min.js"></script>
<script src="<?= $baseUrl ?>/js/highlight.min.js"></script>
<script src="<?= $baseUrl ?>/js/main.js"></script>

</body>
</html>
<?php $this->endPage() ?>

