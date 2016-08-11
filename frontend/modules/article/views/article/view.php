<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = Html::encode($article->title);
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="article-view">

    <article id="58" class="post tag-xin-ban-ben-fa-bu tag-laravel-5-2">

        <header class="post-head">
            <h1 class="post-title"><?= Html::encode($article->title) ?></h1>
            <section class="post-meta">
                <span class="author">作者：<a><?= Html::encode($article->author) ?></a></span>
                &nbsp;&bull;&nbsp;
                <time class="post-date" datetime="<?= date('Y年m月d日H点i分', $article->addtime) ?>" title="<?= date('Y年m月d日H点i分', $article->addtime) ?>">
                    <?= date('Y年m月d日', $article->addtime) ?>
                </time>
            </section>
        </header>

        <?php if($article->thumbnail):?>
        <section class="featured-media">
            <img src="<?= $article->thumbnail ?>" alt="<?= Html::encode($article->title) ?>">
        </section>
        <?php endif ?>

        <section class="post-content">
            <?= HtmlPurifier::process($article->content) ?>
        </section>

        <footer class="post-footer clearfix">
            <div class="pull-left tag-list">
                <i class="fa fa-folder-open-o"></i>
                <?php foreach($article->tags as $k => $tag): ?>
                    <?php if($k > 0):?>,<?php endif ?>
                        <a href="<?= Url::to(['tag/view', 'id' => $tag['id']]) ?>"><?= Html::encode($tag['tagname']) ?></a>
                <?php endforeach ?>
            </div>

            <div class="pull-right share">
                <div class="bdsharebuttonbox share-icons">
                    <a href="#" class="bds_more" data-cmd="more"></a>
                    <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                    <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                    <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                    <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                    <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                </div>
            </div>
        </footer>

        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?= $article->id ?>" data-title="$article->title" data-url="<?= Url::to(['view', 'id' => $article->id]) ?>"></div>
        <!-- 多说评论框 end -->

    </article>

</div>



<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
<script type="text/javascript">
    var duoshuoQuery = {short_name:"zyeeorg"};
    (function() {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';ds.async = true;
        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0]
        || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
</script>
<!-- 多说公共JS代码 end -->
