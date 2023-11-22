<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $created_at;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_confirmation'], 'required'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Zа-яА-Я]+$/u', 'message' => 'Ваше сообщение об ошибке'],

            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => '\app\models\User'],
            [['password'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
            [['password'], 'string', 'min' => 6],
            [['password_confirmation'], 'compare', 'compareAttribute' => 'password'],
            [['created_at'], 'default', 'value' => date('Y-m-d H:i:s')],
        ];
    }

    /**
     * Registers a new user.
     * @return bool whether the user is registered successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            // dd($user->username);

            $user->email = $this->email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->save();
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());
            return true;
        }
        return false;
    }
}
