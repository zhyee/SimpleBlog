<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/5 0005
 * Time: 15:52
 */

namespace common\widgets;

use common\models\Article;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Url;

class LatestArticleWidget extends Widget
{
    const ARTICLE_SIZE = 3;    //显示最新文章的数目

    public function run()
    {
        $articles = Article::find()
            ->where(['is_del' => 0])
            ->orderBy(['id' => SORT_DESC])
            ->limit(static::ARTICLE_SIZE)
            ->all();

        $out = '';
        if($articles){
            foreach($articles as $arc){
                $url = Url::to(['/article/article/view', 'id' => $arc['id']]);
                $title = Html::encode($arc['title']);
                $time = date('Y年m月d日', $arc['publish_time']);
                $out .= <<<EOT
                       <div class="recent-single-post">
                            <a href="{$url}" class="post-title">{$title}</a>
                            <div class="date">{$time}</div>
                       </div>

EOT;
            }
        }

        return $out;
    }
}