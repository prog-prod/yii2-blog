<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m230120_170938_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
            'comment_id' => $this->integer()->null(),
            'text' => $this->text()->null(),
            'viewed' => $this->boolean(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        // create index for column `user_id`
        $this->createIndex(
            'idx-post-user_id',
            'comment',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-comment-post-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // create index for column `article_id`
        $this->createIndex(
            'idx-article_id',
            'comment',
            'article_id'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        // create index for column `comment_id`
        $this->createIndex(
            'idx-comment_id',
            'comment',
            'comment_id'
        );

        // add foreign key
        $this->addForeignKey(
            'fk-comment_id',
            'comment',
            'comment_id',
            'comment',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
