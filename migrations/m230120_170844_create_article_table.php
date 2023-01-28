<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articles}}`.
 */
class m230120_170844_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'content' => $this->text()->null(),
            'image' => $this->string()->null(),
            'views' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        // create index for column `topic_id`
        $this->createIndex(
            'idx-category_id',
            'article',
            'category_id'
        );

        // add foreign key for table `topic`
        $this->addForeignKey(
            'fk-category_id',
            'article',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        // create index for column `user_id`
        $this->createIndex(
            'idx-post-user_id',
            'article',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-user_id',
            'article',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
