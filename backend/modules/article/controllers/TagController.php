<?php

namespace backend\modules\article\controllers;

use Yii;
use yii\data\Pagination;
use common\constants\TagConstant;
use common\exceptions\TagException;
use common\models\Tag;

class TagController extends ArticleBaseController
{

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
        if(NULL === $tag){
            throw new TagException('不存在该标签');
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