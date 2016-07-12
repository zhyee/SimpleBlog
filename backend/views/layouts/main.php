<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\widgets\LatestArticleWidget;
use common\widgets\TagCloudWidget;
use yii\helpers\Url;

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="夜小楼的个人博客" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= Html::csrfMetaTags() ?>

    <?= $this->head() ?>
    <link rel="shortcut icon" href="/images/favicon.ico">

    <link rel="stylesheet" href="/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back/css/vs.min.css">
    <link rel="stylesheet" href="/back/css/screen.css" />

    <script>
        var _hmt = _hmt || [];
    </script>

</head>

<body class="home-template">
<?php $this->beginBody() ?>

<!-- start header -->
<header class="main-header">
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>愿你做的所有事情 都是因为喜欢</h1>
        </div>
    </div>
</div>
</header>
<!-- end header -->

<!-- start nav -->
<?php
NavBar::begin([
    'options' => [
        'class' => 'main-navigation',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'menu'],
    'items' => [
        ['label' => '文章列表', 'url' => ['/article/article/index']],
        ['label' => '添加文章', 'url' => ['/article/article/create']],
        ['label' => '文章回收站', 'url' => ['/article/article-recycle/index']],
        Yii::$app->user->isGuest ? (
        ['label' => '登录', 'url' => ['/user/login']]
        ) :
            (['label' => '退出(' . Yii::$app->user->identity->username . ')', 'url' => ['/user/logout']])
    ],
]);
NavBar::end();
?>
<!-- end nav -->

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

                        <a href="<?= Url::to(['article/tag/index']) ?>">...</a>
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
            <div class="col-sm-12">
                <span>Copyright &copy; <a href="http://zyee.org">zyee.org</a></span>
                |
                <span><a href="http://www.miibeian.gov.cn/" target="_blank">皖ICP备14016681号-2</a></span>
            </div>
        </div>
    </div>
</div>

<a href="#" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<?php $this->endBody() ?>

<script src="/back/js/jquery.fitvids.min.js"></script>
<script src="/back/js/highlight.min.js"></script>
<script src="/back/js/main.js"></script>

</body>
</html>
<?php $this->endPage() ?>

