<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\debug\models\router\RouterRules;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash',], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['username', 'match', 'pattern' => '/^[a-zA-Zа-яА-ЯёЁ]+$/u', 'message' => 'Имя может содержать только буквы'],
            ['password_hash', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z]).{6,}$/', 'message' => 'Пароль должен содержать хотя бы одну цифру и быть не менее 6 символов'],
            // ['password_confirmation', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'логин',
            'email' => 'email',
            'password_hash' => 'пароль',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }



    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAllRoles()
    {
        $arr = \Yii::$app->authManager->getRoles();
        $roles = [];
        $i = 0;
        foreach ($arr as $key => $value) {
            $roles[$i] = $value->name;
            $i++;
        }
        return $roles;
    }

    public function IsChecked($value)
    {
        if (\Yii::$app->authManager->getAssignment('admin', $this->id) && $value === 'admin') {
            return 'checked';
        };
        if (!\Yii::$app->authManager->getAssignment('admin', $this->id) && $value === 'user') {
            return 'checked';
        };
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
