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

        <table class="table table-striped table-bordered"><thead>
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
                    <a class="btn-xs btn-default" href="<?= Url::toRoute(['recovery', 'id' => $arc['id']]) ?>" title="恢复" aria-label="Recovery">
                        <i class="fa fa-recycle"></i>
                    </a>
                    <a class="btn-xs btn-default" action="delete" rel="<?= Url::toRoute(['delete', 'id' => $arc['id']]) ?>" href="javascript:;" title="彻底删除" aria-label="Delete" >
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach ?>

            </tbody>
        </table>

    <?= SimplePagerWidget::widget(['pagination' => $pagination]) ?>

</div>

<div id="confirm" class="sr-only">
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
