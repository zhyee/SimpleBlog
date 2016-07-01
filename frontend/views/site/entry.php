<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/13
 * Time: 23:09
 */

use yii\helpers\Html;

?>

<p>you have entry the following information:</p>
<ul>
    <li><label>Name:</label><?php echo Html::encode($model->name); ?></li>
    <li><label>Email:</label><?php echo Html::encode($model->email);?></li>
</ul>