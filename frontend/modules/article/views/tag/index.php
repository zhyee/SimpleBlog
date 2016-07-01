<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/5 0005
 * Time: 17:10
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>

    <article class="post page">

        <header class="post-head">
            <h1 class="post-title">标签云</h1>
        </header>

        <section class="post-content widget">

            <div class="tag-cloud">

                <?php foreach($tags as $tag): ?>
                    <a href="<?= Url::to(['tag/view', 'id' => $tag['id']]) ?>"><?= Html::encode($tag['tagname']) ?></a>
                <?php endforeach ?>

            </div>

        </section>

    </article>