<?php
/**
 * 文章回收站 - 控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/28 0028
 * Time: 9:18
 */

namespace backend\modules\article\controllers;

use common\models\Article;
use common\models\TagIndex;
use yii\data\Pagination;

class ArticleRecycleController extends ArticleBaseController
{
    /**
     * 分页大小
     * @var
     */
    const RECYCLE_PAGESIZE = 10;

    /**
     * 回收站首页
     */
    public function actionIndex()
    {
        $pagination = new Pagination([
            'defaultPageSize' => self::RECYCLE_PAGESIZE,
            'totalCount' => Article::find()->where(['is_del' => 1])->count()
        ]);

        $articles = Article::find()
            ->where(['is_del' => 1])
            ->orderBy(['del_time' => SORT_DESC, 'id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination
        ]);
    }

    /**
     * 恢复删除文章
     * @todo 标签计数
     */
    public function actionRecovery()
    {
        $id = (int)\Yii::$app->request->get('id');
        if(!$id){
            $this->error('文章ID参数不正确');
        }

        $article = Article::findOne($id);

        if(!$article){
            $this->error('文章不存在');
        }

        //更新标签引用计数
        $article->updateTagCount(1);

        if(Article::updateAll(['is_del' => 0, 'del_time' => 0], ['id' => $id])){
            $this->redirect(['/article/index']);
        }else{
            $this->error('恢复文章失败');
        }
    }

    /**
     * 物理删除文章
     */
    public function actionDelete()
    {
        $id = (int)\Yii::$app->request->get('id');
        if(!$id){
            $this->error('文章ID参数不正确');
        }
        if(Article::deleteAll(['id' => $id])){
            TagIndex::deleteAll(['article_id' => $id]);//删除标签对应关系
            $this->redirect(['index']);
        }else{
            $this->error('删除文章失败');
        }
    }
}