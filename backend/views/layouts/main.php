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
    <link rel="stylesheet" href="/back/css/jquery-ui.css">

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
            <h1>永远年轻 永远热泪盈眶</h1>
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
                        <a href="http://www.bootcss.com" title="Bootstrap中文网" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'bootcsscom'])" target="_blank">Bootstrap中文网</a>
                        <a href="http://www.bootcdn.cn" title="开放CDN服务" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'bootcdncn'])" target="_blank">开放CDN服务</a>
                        <a href="http://www.gruntjs.net" title="Grunt中文网" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'gruntjsnet'])" target="_blank">Grunt中文网</a>
                        <a href="http://www.gulpjs.com.cn/" title="Gulp中文网" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'gulpjscomcn'])" target="_blank">Gulp中文网</a>
                        <hr>
                        <a href="http://lodashjs.com/" title="Lodash中文文档" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'lodashjscom'])" target="_blank">Lodash中文文档</a>
                        <a href="http://www.jquery123.com/" title="jQuery中文文档" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'jquery123com'])" target="_blank">jQuery中文文档</a>
                        <hr>
                        <a href="https://www.upyun.com/" title="又拍云" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'upyun'])" target="_blank">又拍云</a>
                        <a href="http://www.ucloud.cn/" title="UCloud" onclick="_hmt.push(['_trackEvent', 'link', 'click', 'ucloud'])" target="_blank">UCloud</a>
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
<script src="/back/js/jquery-ui.min.js"></script>
<script src="/back/js/jquery.lazyload.min.js"></script>

<script>
    $(function(){
        $("img.lazyload").lazyload({
            effect : "fadeIn"
        });
    });
</script>

</body>
</html>
<?php $this->endPage() ?>

