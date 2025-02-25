<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string $password
 * @property int|null $id_role
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property int|null $is_deleted
 * @property string|null $date_create
 * @property Role|null $role
 * @property UserRole|null $userRole
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $remember_me;
    public $accept_terms;

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
            [['username', 'password'], 'required'],
            [['is_deleted'], 'integer'],
            [['date_create'], 'safe'],
            [['username', 'email', 'password', 'pin', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['remember_me', 'accept_terms'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'pin' => 'Pin',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'is_deleted' => 'Is Deleted',
            'date_create' => 'Date Create',
        ];
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findByusername($username)
    {
        $_username = strtolower($username);
        return self::findOne(['username' => $_username]);
    }

    public static function findByEmail($email)
    {
        $_email = strtolower($email);
        return self::findone(['email' => $_email]);
    }

    public function setPasswordHash()
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
    }

    public function beforeSave($insert)
    {
        $this->username = strtolower($this->username);
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function getUserRole()
    {
        return $this->hasOne(UserRole::class, ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'id_role'])->via('userRole');
    }

    public function softDelete()
    {     
        $this->updateAttributes([
            'is_deleted' => 1
        ]);

        return true;
    }

    public function getBadgeStatus()
    {
        $text = $this->is_deleted == '0' ? 'Active' : 'Inactive';

        $html = <<<HTML
                <span class="badge badge-light-dark">$text</span>
        HTML;

        if ($this->is_deleted == '0') {
            $html = <<<HTML
                    <span class="badge badge-light-success">$text</span>
            HTML;
        }

        return $html;
    }

}
