<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/28 0028
 * Time: 18:27
 */

namespace frontend\modules\api\controllers;
use Yii;
use yii\data\Pagination;
use frontend\modules\api\models\Article;

class ArticleController extends ApiController {

    const PAGE_SIZE = 5;


    /**
     * @SWG\Get(
     *     path="/article/list",
     *     summary="分页获取文章数据",
     *     tags={"文章接口"},
     *     description="获取当前页的文章数据",
     *     operationId="list",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="当前的分页页码",
     *         required=false,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="请求成功",
     *         @SWG\Schema(ref="#/definitions/article")
     *     ),
     *
     * )
     */

    public function actionList() {
        $query = Article::find();

        $pagenation = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => self::PAGE_SIZE]);

        $artilces = $query->offset($pagenation->offset)->limit($pagenation->limit)->asArray()->all();

        return ['articles' => $artilces, 'pagination' => $pagenation];
    }


    /**
     * @SWG\Get(
     *     path="/article/view",
     *     summary="获取单篇文章的详情",
     *     description="获取单篇文章的详情",
     *     operationId="view",
     *     tags={"文章接口"},
     *     consumes={"application/json",},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         description="文章id",
     *         in="query",
     *         name="id",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/article")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="无效的id参数"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="该文章不存在"
     *     )
     * )
     */

    public function actionView() {
        $id = Yii::$app->request->get('id', NULL);
        if($id === NULL) {
            throw new \yii\web\BadRequestHttpException();
        }

        $article = Article::find()->where(['id' => $id])->asArray()->one();
        if(!$article) {
            throw new  \yii\web\NotFoundHttpException();
        }

        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $article;

    }

}