<?php

namespace backend\modules\article\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use common\models\Article;
use common\models\ArticleForm;
use common\exceptions\ArticleException;

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
            'defaultPageSize' => 10,
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
     * Displays a single Article model.
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

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleForm();
        $request = Yii::$app->request;

        if($request->isPost)
        {
            if($model->add($request->post()))
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                return $this->error('添加文章失败');
            }
        }
        else
        {
            $model = new ArticleForm();
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return string|void
     * @throws ArticleException
     */
    public function actionUpdate()
    {

        $request = Yii::$app->request;
        $id = (int)$request->get('id', 0);
        if(!$id){
            throw new InvalidParamException('ID参数错误');
        }

        if($request->isPost)
        {
            $model = new ArticleForm();
            $model->load($request->post());
            return $model->update();
        }
        else
        {
            $model = ArticleForm::findOne(['id' => $id, 'is_del' => 0]);
            if (NULL === $model)
            {
                throw new ArticleException('该文章不存在');
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return string|\yii\web\Response
     * @throws ArticleException
     */
    public function actionDelete()
    {
        $id = (int)Yii::$app->request->get('id', 0);
        if(!$id)
        {
            throw new ArticleException('ID参数不正确');
        }

        $article = Article::findOne(['id' => $id]);

        if(NULL === $article)
        {
            throw new ArticleException('该文章不存在');
        }

        if($article->delete())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->error('删除文章失败');
        }
    }

}
