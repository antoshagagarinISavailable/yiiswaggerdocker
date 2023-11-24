<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class UserUpdate extends Model
{
    public $password;
    public $newPassword;
    public $newPasswordConfirm;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'newPassword', 'newPasswordConfirm'], 'required'],
            ['password', 'validatePassword'],
            [['newPassword'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
            [['newPassword'], 'string', 'min' => 6,],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'newPassword', 'message' => 'введённые пароли не совпадают'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'newPassword' => 'Новый пароль',
            'newPasswordConfirm' => 'Повторите новый пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный пароль');
            }
        }
    }


    /**
     * Finds user
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findIdentity(Yii::$app->user->id);
        }

        return $this->_user;
    }
    public function passwordChange()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->newPassword);
            return $user->save();
        }
    }
}
