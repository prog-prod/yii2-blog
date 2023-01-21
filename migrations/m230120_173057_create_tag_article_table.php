<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags_articles}}`.
 */
class m230120_173057_create_tag_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag_article}}', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
        ]);

        // create index for column `tag_id`
        $this->createIndex(
            'idx-tag_id',
            'tag_article',
            'tag_id'
        );

        // add foreign key for table `tag_id`
        $this->addForeignKey(
            'fk-tag-article_tag_id',
            'tag_article',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );

        // create index for column `article_id`
        $this->createIndex(
            'idx-article_id',
            'tag_article',
            'article_id'
        );

        // add foreign key for table `tag_article`
        $this->addForeignKey(
            'fk-tag-article_article_id',
            'tag_article',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_article}}');
    }
}
