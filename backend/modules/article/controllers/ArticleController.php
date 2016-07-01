<?php

namespace backend\modules\article\controllers;

use Yii;
use common\models\Article;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $article = new Article();
        $request = Yii::$app->request;

        if($request->isPost){
            $data = $request->post();
            $article->load($data);
            $article->preSave();
            if($article->validate()){
                if(isset($data[$article->formName()])){
                    $data = $data[$article->formName()];
                }
                if($article->add($data)){
                    return $this->redirect(['view', 'id' => $article->id]);
                }else{
                    return $this->error('添加文章失败');
                }
            }else{
                print_r($article->errors);
            }
        } else {
            return $this->render('create', [
                'model' => $article
            ]);
        }
    }


    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $id = intval($id);
        if(!$id){
            return $this->error('ID参数错误');
        }

        $article = Article::findOne(['id' => $id, 'is_del' => 0]);

        if(!$article){
            return $this->error('文章不存在');
        }

        $request = Yii::$app->request;
        if($request->isPost){
            $data = $request->post();
            $article->load($data);
            $article->preSave();
            if(isset($data[$article->formName()])){
                $data = $data[$article->formName()];
            }
            if($article->add($data, true)){
                $this->redirect(['index']);
            }else{
                return $this->error('文章保存失败');
            }
        }else{
            $tags = $article->tags;
            $tags = ArrayHelper::getColumn($tags, 'tagname');
            $article->inputTags = implode(' ', $tags);
            return $this->render('update', [
                'model' => $article,
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
