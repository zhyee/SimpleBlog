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
                <span class="author">作者：<a><?= Html::encode($article->author) ?></a></span> &bull;
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
                <?php foreach($article->tag as $k => $tag): ?>
                    <?php if($k > 0):?>,<?php endif ?>
                        <a href="<?= Url::to(['tag/view', 'id' => $tag['tid']]) ?>"><?= Html::encode($tag['tname']) ?></a>
                <?php endforeach ?>
            </div>
            <div class="pull-right edit">
                <i class="fa fa-pencil"></i>
                <a href="<?= Url::to(['article/update', 'id' => $article->id]) ?>">编辑</a>

                <i class="fa fa-trash-o"></i>
                <a href="<?= Url::to(['article/delete', 'id' => $article->id]) ?>">删除</a>
            </div>

        </footer>

    </article>

</div>
