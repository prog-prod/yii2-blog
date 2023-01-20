<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const ROLE_READER = 1;
    const ROLE_AUTHOR = 5;
    const ROLE_ADMIN = 10;


    public static function roles()
    {
        return [
            self::ROLE_READER => Yii::t('app', 'Reader'),
            self::ROLE_ADMIN => Yii::t('app', 'Admin'),
            self::ROLE_AUTHOR => Yii::t('app', 'Author'),
        ];
    }

    public function hasAdminPanelAccess(): bool
    {
        return $this->isAdmin() || $this->isAuthor();
    }
    public function getRoleName(int $id)
    {
        $list = self::roles();
        return $list[$id] ?? null;
    }

    public function isAdmin(): bool
    {
        return ($this->role == self::ROLE_ADMIN);
    }

    public function isAuthor(): bool
    {
        return ($this->role == self::ROLE_AUTHOR);
    }

    public function isReader(): bool
    {
        return ($this->role == self::ROLE_READER);
    }

    public static function tableName()
    {
        return '{{%user}}';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function isUserAdmin($username): bool
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_ADMIN])) {

            return true;
        } else {

            return false;
        }

    }
}
