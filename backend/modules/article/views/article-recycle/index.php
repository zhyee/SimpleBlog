<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\SimplePagerWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '回收站';
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="article-index">

        <?php if(!empty($articles)): ?>
        <table class="table"><thead>
            <tr><th>编号</th><th>文章标题</th><th>作者</th><th>发布时间</th><th class="action-column">操作</th></tr>
            </thead>
            <tbody>

            <?php foreach($articles as $index => $article): ?>
            <tr data-key="4">
                <td><?= $pagination->offset+$index+1 ?></td>
                <td><?= Html::encode($article['title']) ?></td>
                <td><?= Html::encode($article['author']) ?></td>
                <td><?= date('Y-m-d H:i', $article['addtime']) ?></td>
                <td>
                    <a href="<?= Url::to(['article-recycle/recovery', 'id' => $article['id']]) ?>" aria-label="Recovery"><i class="fa fa-recycle"></i>恢复
                    </a>
                    <a class="ml-10" data-toggle="modal" data-target="#confirm-modal" data-url="<?= Url::to(['article-recycle/delete', 'id' => $article['id']]) ?>" rel="delete" href="javascript:;" aria-label="Delete"><i class="fa fa-trash"></i>彻底删除
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
        <?php else:?>
            <div class="no-data mb-20">
                <p class="text-center">暂无数据</p>
            </div>
        <?php endif; ?>

    <?= SimplePagerWidget::widget(['pagination' => $pagination]) ?>

</div>


<div class="modal fade" id="confirm-modal" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">确认删除</h4>
            </div>

            <div class="modal-body">
                <p>确认要删除吗，删除后无法恢复？</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-sm btn-success">确定</button>
            </div>
        </div>
    </div>
</div>

<script>

    /* 点击确认删除按钮 */
    $(function () {
        var deleteUrl = '';
        $('a[rel="delete"]').click(function () {
           deleteUrl = $(this).data('url');
        });
        $(document).on('click', '#confirm-modal .modal-footer button:last-child', function () {
            location.href = deleteUrl;
        });
    });


</script>
