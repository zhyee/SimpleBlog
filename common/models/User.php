<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const ENV_REGISTER = 'register';
    const ENV_LOGIN = 'login';
    const USER_STATUS_DELETED = 1;   //被删除
    const USER_STATUS_ACTIVE = 0;    //正常
    const USER_ONLINE = 1;  //在线
    const USER_OFFLINE = 2; //离线

    public $verifyCode;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return array_merge($scenarios, [
            self::ENV_REGISTER => ['username', 'password', 'email']
        ]);
    }

    public function rules()
    {
        return [
            [['username', 'password', 'email', 'verifyCode'], 'required', 'on' => self::ENV_REGISTER],
            ['email', 'email'],
            ['verifyCode', 'captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->getId() ? md5($this->getId() . \Yii::$app->request->cookieValidationKey) : NULL;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    //密码加密
    private static function encryptPassword($password){
        return md5($password . \Yii::$app->request->cookieValidationKey);
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === self::encryptPassword($password);
    }

    public function attributeLabels()
    {
        return [
            'username'      => '用户名',
            'password'      => '密码',
            'email'         => '邮箱',
            'verifyCode'    =>  '验证码'
        ];
    }


    /**
     * 用户注册
     */
    public function register()
    {
        if($this->password){
            $this->password = self::encryptPassword($this->password);
        }
        $this->register_time = time();
        return $this->save();
    }
}
