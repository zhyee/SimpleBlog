<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/5 0005
 * Time: 16:26
 */

namespace common\widgets;

use common\models\Tag;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Url;

class TagCloudWidget extends Widget
{
    const MAX_SHOW_COUNT = 15;    //最多显示的标签数

    public function run()
    {
        $tags = Tag::find()
            ->where(['>', 'usecount', 0])
            ->orderBy(['usecount' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(static::MAX_SHOW_COUNT)
            ->asArray()
            ->all();

        $out = '';
        if($tags){
            foreach($tags as $tag)
            {
                $url = Url::to(['/article/tag/view', 'id' => $tag['id']]);
                $tagname = Html::encode($tag['name']);
                $out .= <<<EOT
                <a href="{$url}">{$tagname}</a>

EOT;
            }
        }

        return $out;
    }
}