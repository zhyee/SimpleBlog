<?php

namespace frontend\modules\article\controllers;

use Yii;
use common\models\Article;
use yii\data\Pagination;
use yii\filters\VerbFilter;


/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends ArticleBaseController
{
    const ARTICLE_PAGESIZE = 10;

    public function actions()
    {
        return [
            'upload' => 'common\actions\UploadAction'
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Article::find();

        $pagination = new Pagination([
            'defaultPageSize' => static::ARTICLE_PAGESIZE,
            'totalCount' => $query->where(['is_del'=>0])->count()
        ]);

        $articles = $query
            ->where(['is_del' => 0])
            ->orderBy(['id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays a single Article model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $id = (int)$id;
        if(!$id){
            return $this->error('ID参数错误');
        }
        $article = Article::findOne(['id' => $id, 'is_del' => 0]);

        if(!$article){
            return $this->error('文章不存在');
        }
        return $this->render('view', [
            'article' => $article
        ]);
    }
}
