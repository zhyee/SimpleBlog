<?php
/**
 * 留言板控制器
 */

namespace backend\modules\article\controllers;
use common\models\Message;
use Yii;
use yii\data\Pagination;
use yii\web\Response;
use yii\helpers\Html;
use common\helpers\CoreHelper;
use yii\web\Cookie;

class MessageController extends ArticleBaseController
{
    /**
     * 每页显示留言的数目
     */
    const MESSAGE_PAGESIZE = 8;

    /**
     * 留言内容的长度限制
     */
    const MESSAGE_MAX_LENGTH = 100;

    /**
     * 留言板首页
     */
    public function actionIndex()
    {
        $query = Message::find();
        $pagination = new Pagination([
            'defaultPageSize' => static::MESSAGE_PAGESIZE,
            'totalCount' => $query->where(['is_del' => 0])->count()
        ]);

        $messages = $query->where(['is_del' => 0])
            ->orderBy(['id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        return $this->renderPartial('index', [
            'messages' => $messages,
            'maxLength' => static::MESSAGE_MAX_LENGTH,
            'pagesize' => static::MESSAGE_PAGESIZE,
            'ubb' => Yii::$app->params['ubb']
        ]);
    }

    /**
     * 发表留言
     */
    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $nickname = trim($request->post('nickname'));
        $content = Html::encode($request->post('content'));
        if(!$nickname){
            return [
                'err_code' => 1,
                'msg' => '请填写昵称'
            ];
        }
        if(!$content){
            return [
                'err_code' => 2,
                'msg' => '请填写留言内容'
            ];
        }
        $ubb = Yii::$app->params['ubb'];
        $pics = array_keys($ubb);
        $names = array_values($ubb);
        $pics2 = [];
        $names2 = [];
        foreach($pics as $k => $pic){
            $pics2[] = '<img src="/images/phiz/' . $pic . '.gif" alt="' . $names[$k] . '">';
        }
        foreach($names as $k => $name){
            $names2[] = '[' . $name . ']';
        }

        $content = str_replace($names2, $pics2, $content);
        $message = new Message();
        $message->nickname = $nickname;
        $message->content = $content;
        $message->addtime = time();
        $message->is_del = 0;
        if($message->save())
        {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new Cookie([
                'name' => 'nickname',
                'value' => $nickname,
                'expire' => time() + (86400 * 365)
            ]));
            $message->nickname = Html::encode($message->nickname);
            $message->addtime = CoreHelper::formatTimestamp($message->addtime);
            $message->id = CoreHelper::zeroFill($message->id);
            return [
                'err_code' => 0,
                'data' => $message
            ];
        } else {
            return [
                'err_code' => 3,
                'msg' => '留言发表失败'
            ];
        }
    }

    /**
     * 获取存在cookie中的nickname
     */
    public function actionGetNickname(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cookies = Yii::$app->request->cookies;
        $nickname = $cookies->getValue('nickname', '');
        return [
            'err_code' => 0,
            'data' =>[
                'nickname' => $nickname
            ]
        ];
    }
}