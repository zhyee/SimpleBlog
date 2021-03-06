<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\SimplePagerWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '所有文章';
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>


    <?php foreach($articles as $index => $arc):?>

    <article id=61 class="post tag-lumen tag-xin-ban-ben-fa-bu">
        <div class="post-head">
            <h1 class="post-title">
                <a href="<?= Url::to(['article/view', 'id' => $arc['id']])?>"><?= Html::encode($arc['title']) ?></a></h1>
            <div class="post-meta">
                <span class="author">作者：<a href=""><?= $arc['author'] ?></a></span> &bull;
                <time class="post-date" datetime="<?= $arc['timeStr'] ?>" title="<?= $arc['timeStr'] ?>"> <?= date('Y年m月d日', $arc['addtime'])?></time>
            </div>
        </div>

        <?php if($arc['thumbnail']): ?>
        <div class="featured-media">
            <a href="<?= Url::to(['article/view', 'id' => $arc['id']])?>">
                <img class="lazyload" data-original="<?= $arc['thumbnail'] ?>" alt="<?= Html::encode($arc['title']) ?>">
            </a>
        </div>
        <?php endif ?>

        <div class="post-content">
            <p><?= Html::encode($arc['description']) ?></p>
        </div>
        <div class="post-permalink">
            <a href="<?= Url::to(['article/view', 'id' => $arc['id']]) ?>" class="btn btn-default">阅读全文</a>
        </div>

        <footer class="post-footer clearfix">
            <div class="pull-left tag-list">
                <i class="fa fa-folder-open-o"></i>
                <?php foreach($arc['tag'] as $k => $tag):?>
                    <?php if($k > 0): ?>,<?php endif ?>
                        <a href="<?= Url::to(['tag/view', 'id' => $tag['tid']])?>"><?= Html::encode($tag['tname']) ?></a>
                <?php endforeach ?>
            </div>
            <div class="pull-right edit">

                <a href="<?= Url::to(['article/update', 'id' => $arc['id']]) ?>"><i class="fa fa-pencil-square-o"></i>编辑</a>

                <a class="ml-10" href="<?= Url::to(['article/delete', 'id' => $arc['id']]) ?>"><i class="fa fa-trash-o"></i>删除</a>
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


