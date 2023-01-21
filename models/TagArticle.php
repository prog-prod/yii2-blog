<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_article".
 *
 * @property int $id
 * @property int $tag_id
 * @property int $article_id
 *
 * @property Article $article
 * @property Tag $tag
 */
class TagArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['tag_id', 'article_id'], 'required'],
            [['tag_id', 'article_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'article_id' => 'Article ID',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
