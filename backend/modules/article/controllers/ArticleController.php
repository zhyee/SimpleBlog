<?php

namespace backend\modules\article\controllers;

use Yii;
use common\models\Article;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\ArticleForm;
use commmon\exceptions\ArticleException;

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
        $article = new Article();
        $query = $article::find();

        $pagination = new Pagination([
            'defaultPageSize' => 10,
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
        $article = new Article();

        $request = Yii::$app->request;

        if($request->isPost)
        {
            $data = $request->post();
            $article->load($data);
            $article->preSave();
            if($article->validate())
            {
                if(isset($data[$article->formName()])){
                    $data = $data[$article->formName()];
                }
                if($article->add($data))
                {
                    return $this->redirect(['view', 'id' => $article->id]);
                }
                else
                {
                    return $this->error('添加文章失败');
                }
            }
            else
            {
                print_r($article->errors);
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
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $id = intval($id);
        if(!$id){
            return $this->error('ID参数不正确');
        }

        $article = Article::findOne(['id' => $id]);

        if(!$article){
            return $this->error('文章不存在');
        }

        if($article->delete()){
            return $this->redirect(['index']);
        }else{
            return $this->error('删除文章失败');
        }
    }

}
