<?php

namespace app\models;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "article".
 * @property int $id
 * @property string $username
 * @property int $user_id
 * @property string $auth_key
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property int $role
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $avatar
 * @property int $created_at
 * @property int $updated_at
 */

class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_READER = 1;
    const ROLE_AUTHOR = 5;
    const ROLE_ADMIN = 10;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @return array
     * @throws InvalidConfigException
     */
    public function behaviors(): array
    {
        $formatter = \Yii::$app->formatter;

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' =>  $formatter->asDatetime('now','Y-MM-dd H:mm:ss')
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username','email'], 'required'],
            [['role'], 'integer'],
            [['first_name', 'last_name','email','avatar'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'role' => 'Role',
            'password_hash' => 'Password',
            'avatar' => 'Avatar image',
        ];
    }

    /**
     * @return array
     */
    public static function roles(): array
    {
        return [
            self::ROLE_READER => Yii::t('app', 'Reader'),
            self::ROLE_ADMIN => Yii::t('app', 'Admin'),
            self::ROLE_AUTHOR => Yii::t('app', 'Author'),
        ];
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        if($this->first_name && $this->last_name){
            return $this->firstName.' '.$this->lastName;
        }

        return $this->username;
    }

    /**
     * @return bool
     */
    public function hasAdminPanelAccess(): bool
    {
        return $this->isAdmin() || $this->isAuthor();
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function getRoleName(int $id)
    {
        return self::roles()[$id] ?? null;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return ($this->role == self::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isAuthor(): bool
    {
        return ($this->role == self::ROLE_AUTHOR);
    }

    /**
     * @return bool
     */
    public function isReader(): bool
    {
        return ($this->role == self::ROLE_READER);
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
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?\yii\web\IdentityInterface
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
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @return void
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param $token
     * @return User|null
     */
    public static function findByPasswordResetToken($token): ?User
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * @param $token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @return void
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param $username
     * @return bool
     */
    public static function isUserAdmin($username): bool
    {
        return !!static::findOne(['username' => $username, 'role' => self::ROLE_ADMIN]);
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar ?: 'author.jpg';
    }

    /**
     * @return ActiveQuery
     */
    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(Article::class, ['user_id' => 'id'])->inverseOf('user');
    }

    public function getAboutMeText() {
        return $this->about_me ?: "Користувач не надав інформацію про себе.";
    }
}
