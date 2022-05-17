<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $role_id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $access_token
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'name', 'surname', 'patronymic', 'login', 'password', 'email'], 'required'],
            [['role_id'], 'integer'],
            [['name', 'surname', 'patronymic', 'login', 'password', 'email', 'access_token', 'auth_key'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord)
            {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->password = \Yii::$app->security->generatePasswordHash($this->password);
                $this->role_id = Role::findByName('user')->id;
            }
            return true;
        }
        return false;
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }

    public function getIsAdmin()
    {
        return $this->role_id == Role::findByName('admin')->id;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
