<?php

namespace frontend\modules\article\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use common\models\Article;
use common\exceptions\ArticleException;
use common\constants\ArticleConstant;


/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends ArticleBaseController
{

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
            'defaultPageSize' => ArticleConstant::ARTICLE_PAGESIZE,
            'totalCount' => $query->where(['is_del'=>0])->count()
        ]);

        $articles = $query
            ->with('tag')
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
     *  Displays a single Article model.
     * @return string
     * @throws ArticleException
     */
    public function actionView()
    {
        $id = (int)Yii::$app->request->get('id', 0);
        if(!$id)
        {
            throw new InvalidParamException('ID参数不正确');
        }
        $article = Article::getDetail(['id' => $id, 'is_del' => 0]);

        if(NULL === $article)
        {
            throw new ArticleException('该文章不存在');
        }

        return $this->render('view', [
            'article' => $article
        ]);
    }
}
