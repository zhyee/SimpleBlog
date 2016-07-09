<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25 0025
 * Time: 18:42
 */
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\SimplePagerWidget;
use common\helpers\CoreHelper;

?>

<div class="cover tag-cover">
    <h3 class="tag-name">
        标签：<?= Html::encode($tag->tagname) ?>
    </h3>
    <div class="post-count">
        共 <?= $pagination->totalCount ?> 篇文章
    </div>
</div>

<?php foreach($articles as $article): ?>
<article id=61 class="post tag-lumen tag-xin-ban-ben-fa-bu">

    <div class="post-head">
        <h1 class="post-title"><a href="<?= Url::to(['/article/view', 'id' => $article['id']]) ?>"><?= Html::encode($article['title']) ?></a></h1>
        <div class="post-meta">
            <span class="author">作者：<a href=""><?= Html::encode($article['author']) ?></a></span>
            &nbsp;&bull;&nbsp;
            <time class="post-date" datetime="<?= CoreHelper::formatTimestamp($article['publish_time']) ?>" title="<?= CoreHelper::formatTimestamp($article['publish_time']) ?>"><?= date('Y年m月d日 H:i', $article['publish_time']) ?></time>
        </div>
    </div>
    <?php if($article['thumbnail']): ?>
    <div class="featured-media">
        <a href="<?= Url::to(['article/view', 'id' => $article['id']]) ?>">
            <img class="lazyload" data-original="<?= $article['thumbnail'] ?>" alt="<?= Html::encode($article['title']) ?>">
        </a>
    </div>
    <?php endif; ?>
    <div class="post-content">
        <p><?= $article['description'] ?></p>
    </div>
    <div class="post-permalink">
        <a href="<?= Url::to(['article/view', 'id' => $article['id']]) ?>" class="btn btn-default">阅读全文</a>
    </div>

    <footer class="post-footer clearfix">
        <div class="pull-left tag-list">
            <i class="fa fa-folder-open-o"></i>
            <?php foreach($article->tags as $k => $tag): ?>
                <?php if($k > 0):?>,<?php endif ?>
                <a href="<?= Url::to(['tag/view', 'id' => $tag['id']]) ?>"><?= Html::encode($tag['tagname']) ?></a>
            <?php endforeach ?>
        </div>
        <div class="pull-right share">
        </div>
    </footer>
</article>

<?php endforeach ?>


<?= SimplePagerWidget::widget(['pagination' => $pagination]) ?>

<?php

    $this->registerJsFile('@web/js/jquery.lazyload.min.js', ['depends' => 'yii\web\JqueryAsset']);

$script = <<<EOT

            $("img.lazyload").lazyload({
                effect : "fadeIn"
            });

EOT;

$this->registerJs($script);

?>

