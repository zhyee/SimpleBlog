<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25 0025
 * Time: 17:15
 */
namespace frontend\modules\article\controllers;

use Yii;
use yii\data\Pagination;
use common\models\Tag;
use common\constants\TagConstant;

class TagController extends ArticleBaseController{

    /**
     * 所有标签
     */
    public function actionIndex()
    {
        $tags = Tag::find()
            ->where(['>', 'usecount', 0])
            ->orderBy(['usecount' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(TagConstant::MAX_SHOW_COUNT)
            ->asArray()
            ->all();

        return $this->render('index', ['tags' => $tags]);
    }


    /**
     * 查看标签
     */
    public function actionView(){
        $id = (int)Yii::$app->request->get('id');
        if(!$id){
            $this->error('标签ID参数错误');
        }

        $tag = Tag::findOne($id);
        if(NULL === $tag)
        {
            $this->error('无法显示该标签');
        }

        $totalCount = $tag->getArticlesCount();

        $pagination = new Pagination([
            'defaultPageSize' => TagConstant::PAGESIZE,
            'totalCount'      => $totalCount
        ]);

        $articles = $tag->getArticles($pagination);

        return $this->render('view', [
            'tag' => $tag,
            'articles' => $articles,
            'pagination' => $pagination
        ]);

    }
}