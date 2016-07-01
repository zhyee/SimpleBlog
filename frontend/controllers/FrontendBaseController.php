<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24 0024
 * Time: 13:43
 */
/**
 * 自定义控制器基类 实现一些基础的方法
 */
namespace frontend\controllers;
use Yii;
use common\controllers\BaseController;

class FrontendBaseController extends BaseController{

    const MESSAGE_SUCCESS = 'success';
    const MESSAGE_ERROR = 'error';

    public function init()
    {
        Yii::setAlias('@images', '@webroot/public/images');    //文件上传目录
        parent::init();
        //@TODO 初始化一些操作
    }

    protected function checkLogin()
    {
        if(Yii::$app->user->isGuest){
            $this->redirect(['/user/login']);
        }
    }

    /**
     * 显示消息提示
     * @param $message
     * @param string $status
     * @return string
     */
    protected function error($message){
        Yii::$app->getSession()->setFlash(self::MESSAGE_ERROR, $message);
        return $this->render('/common/message');
    }

    protected function success($message){
        Yii::$app->getSession()->setFlash(self::MESSAGE_SUCCESS, $message);
        return $this->render('/common/message');
    }
}