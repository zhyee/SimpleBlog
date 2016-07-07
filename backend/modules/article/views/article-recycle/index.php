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

            <?php foreach($articles as $index => $arc): ?>
            <tr data-key="4">
                <td><?= $pagination->offset+$index+1 ?></td>
                <td><?= Html::encode($arc['title']) ?></td>
                <td><?= Html::encode($arc['author']) ?></td>
                <td><?= date('Y-m-d H:i', $arc['publish_time']) ?></td>
                <td>
                    <span class="separator"></span>
                    <i class="fa fa-recycle"></i><a href="<?= Url::to(['article-recycle/recovery', 'id' => $arc['id']]) ?>" aria-label="Recovery">恢复
                    </a>
                    <span class="separator"></span>
                    <i class="fa fa-trash"></i><a action="delete" rel="<?= Url::to(['article-recycle/delete', 'id' => $arc['id']]) ?>" href="javascript:;" aria-label="Delete">彻底删除
                    </a>
                </td>
            </tr>
            <?php endforeach ?>

            </tbody>
        </table>
        <?php else:?>
            <div class="no-data">
                <p class="text-center">暂无数据</p>
            </div>
        <?php endif; ?>

    <?= SimplePagerWidget::widget(['pagination' => $pagination]) ?>

</div>

<div id="confirm" class="hidden">
    <p>确认要删除吗，删除后无法恢复？</p>
</div>

<script>

    window.onload = function(){
        $('a[action="delete"]').click(function(){
            var url = $.trim($(this).attr('rel')) || '';
            $('#confirm').dialog({
                title : '确认',
                closeText : '',
                modal : true,
                buttons : [
                    {
                        text : '确定',
                        click : function(){
                            location.href = url;
                        }
                    },
                    {
                        text : '取消',
                        click : function(){
                            $(this).dialog('close');
                        }
                    }
                ]
            })
        });
    };

</script>

</div>
