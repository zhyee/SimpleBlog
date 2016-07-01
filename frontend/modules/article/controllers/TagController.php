<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25 0025
 * Time: 17:15
 */
namespace frontend\modules\article\controllers;
use common\models\Tag;
use Yii;
use yii\data\Pagination;

class TagController extends ArticleBaseController{

    const PAGESIZE = 10;
    const MAX_SHOW_COUNT = 200;    //最多显示的标签数

    /**
     * 所有标签
     */
    public function actionIndex()
    {
        $tags = Tag::find()
            ->where(['>', 'usecount', 0])
            ->orderBy(['usecount' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(static::MAX_SHOW_COUNT)
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
        if(!$tag){
            $this->error('无法显示该标签');
        }

        $totalCount = $tag->articlesCount;

        $pagination = new Pagination([
            'defaultPageSize' => self::PAGESIZE,
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