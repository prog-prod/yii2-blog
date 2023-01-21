<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 *
 * @property TagArticle[] $tagArticles
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[TagArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagArticles(): \yii\db\ActiveQuery
    {
        return $this->hasMany(TagArticle::class, ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Article::class, ['id' => 'article_id'])
            ->viaTable('tag_article',[ 'tag_id' => 'id']);
    }

}
