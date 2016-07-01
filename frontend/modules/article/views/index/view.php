<?php
use yii\Helpers\Html;
?>
<h1>I want a date with you</h1>
<h1><?=Html::encode($name)?></h1>
<h2><?=$age?></h2>

<?php
    foreach($hobbies as $hobby){
        echo '<h3>' . $hobby . '</h3>';
    }
?>


