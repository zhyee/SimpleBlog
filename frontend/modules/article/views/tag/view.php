<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25 0025
 * Time: 18:42
 */
use yii\helpers\Html;
use yii\helpers\Url;

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
        <h1 class="post-title"><a href="<?= Url::to(['article/view', 'id' => $article['id']]) ?>"><?= Html::encode($article['title']) ?></a></h1>
        <div class="post-meta">
            <span class="author">作者：<a href="/author/wangsai/"><?= Html::encode($article['author']) ?></a></span>
            &nbsp;&bull;&nbsp;
            <time class="post-date" datetime="2016年1月8日星期五上午10点33分" title="<?= date('Y年m月d日H点i分', $article['publish_time']) ?>"><?= date('Y年m月d日', $article['publish_time']) ?></time>
        </div>
    </div>
    <div class="featured-media">
        <a href="/post/lumen-5-2-is-released/"><img src="http://image.golaravel.com/e/d5/0dd5c3a731c98638a076afe8ce6de.png" alt="Lumen 5.2 正式发布"></a>
    </div>
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
<nav class="pagination" role="navigation">
    <span class="page-number">第 1 页 &frasl; 共 1 页</span>
</nav>