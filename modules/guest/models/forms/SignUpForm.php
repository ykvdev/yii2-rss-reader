<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserModel;
use yii\base\Model;
use yii\helpers\Url;

class SignUpForm extends Model
{
    public $email, $password, $repassword, $captcha, $acceptAgreement;

    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'Введите e-mail адрес'],
            ['email', 'email', 'message' => 'E-mail адрес введен не корректно'],
            ['email', 'string', 'max' => 50,
                'message' => 'Максимально допустимая длинна e-mail адреса составляет 50 символов'],
            ['email', 'unique', 'targetClass' => UserModel::className(),
                'message' => 'Такой e-mail адрес уже зарегистрирован'],

            // ['login', 'string', 'min' => 2, 'max' => 255],
            // если бы был логин, то нужно было бы добавить проверку на длину мин 2 символа

            ['password', 'required', 'message' => 'Введите пароль'],
            ['password', 'string', 'min' => 3, 'tooShort' => 'Пароль должен быть не короче 3-х символов'],
            ['repassword', 'required', 'message' => 'Повторите пароль'],
            [['password', 'repassword'], 'compare', 'compareAttribute' => 'password',
                'message' => 'Введенные пароли не совпадают'],

            ['captcha', 'filter', 'filter' => 'trim'],
            ['captcha', 'required', 'message' => 'Введите проверочные символы'],
            ['captcha', 'captcha', 'captchaAction' => Url::toRoute('/common/common/captcha'),
                'message' => 'Проверочные символы введены не верно'],

            ['acceptAgreement', 'boolean'],
            ['acceptAgreement', 'required', 'requiredValue' => true, 'message' => 'Вы должны принять условия соглашения'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'E-mail адрес',
            'password' => 'Введите пароль',
            'repassword' => 'Повторите пароль',
            'captcha' => 'Введите проверочные символы',
            'acceptAgreement' => 'Принять условия пользовательского сглашения (ссылка)' // todo add link
        ];
    }

    /**
     * @return UserModel|bool
     */
    public function signUp() {
        if(!$this->validate()) {
            return false;
        }

        $user = new UserModel();
        $user->email = $this->email;
        $user->password = $this->password;
        $user->registered_at = date('Y-m-d H:i:s');

        if($user->save()) {
            return $user;
        } else {
            return false;
        }
    }
}