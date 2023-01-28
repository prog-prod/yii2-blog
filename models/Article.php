<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $image
 * @property int $views
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $category
 * @property Comment[] $comments
 * @property TagArticle[] $tagArticles
 * @property User $user
 */
class Article extends \yii\db\ActiveRecord
{

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
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id', 'title', 'content'], 'required'],
            [['category_id', 'user_id', 'views'], 'integer'],
            [['description'], 'string'],
            [['content'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'description' => 'Description',
            'image' => 'Image',
            'views' => 'Views',
        ];
    }

    public function getBgImage()
    {
        $images = $this->getImages();
        return $images[0];
    }

    public function getImages(): array
    {
        $images = explode(',', $this->image);
        if(strlen($images[0]) === 0) {
            $images[0] = \Yii::$app->params['default_article_img'];
        }
        return $images;
    }
    public function getShortContent(): string
    {
        return StringHelper::byteSubstr($this->content,0, 255).'...';
    }
    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    /**
     * Gets query for [[TagArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagArticles(): \yii\db\ActiveQuery
    {
        return $this->hasMany(TagArticle::class, ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('tag_article', ['article_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
