<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/23 0023
 * Time: 11:33
 */

namespace backend\controllers;

use common\controllers\BaseController;
use Yii;
use common\models\User;
use common\models\LoginForm;

class UserController extends BaseController
{

    public function actions()
    {
        return [
            'captcha' => [
                'class'     => 'yii\captcha\CaptchaAction',
                'minLength' => 4,
                'maxLength' => 4,
                'height'    => 34,
            ]
        ];
    }

    //用户注册
    public function actionRegister()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = new User();
        $request = Yii::$app->request;
        if($request->isPost)
        {
            $model->scenario = 'register';
            $model->load($request->post());
            if($model->validate()){
                if($model->register()){
                    if(Yii::$app->user->login($model)){
                        return $this->goHome();
                    }
                }
            }else{
                print_r($model->errors);
            }
        } else {
            return $this->render('register', [
                'model' => $model
            ]);
        }
    }

    /**
     * 用户登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * 用户退出登录
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}