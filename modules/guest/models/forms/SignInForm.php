<?php

namespace app\modules\guest\models\forms;

use Yii;
use yii\base\Model;
use app\modules\common\models\db\UserModel;

class SignInForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    /** @var bool|UserModel */
    private $user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Введите e-mail'],
            ['password', 'required', 'message' => 'Введите пароль'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
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

            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Не корректное имя пользователя или пароль');
            }
        }
    }

    public function attributeLabels() {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    /**
     * @return bool|\yii\web\Response
     */
    public function signIn()
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->getUser()->signIn($this->rememberMe);
    }

    /**
     * @return UserModel|null
     */
    public function getUser()
    {
        if (!$this->user) {
            $this->user = UserModel::findOne(['email' => $this->email]);
        }

        return $this->user;
    }
}
