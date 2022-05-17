<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $login;
    public $email;
    public $password;
    public $password_repeat;
    public $rules;
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'surname', 'password', 'password_repeat', 'rules', 'login'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [['login','email'], 'unique', 'targetClass' => User::class],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'password_repeat' => 'Password repeat',
        ];
    }

    public function registration()
    {
        if ($this->validate())
        {
            $user = new User();
            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->patronymic = $this->patronymic;
            $user->login = $this->login;
            $user->password = $this->password;
            $user->email = $this->email;
            if ($user->save())
            {
                Yii::$app->session->setFlash('success', 'Успешная регистрация');
                return $user;
            }

            Yii::$app->session->setFlash('error', 'Ошибка регистрации');
        }

        return false;
    }

}
