<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m160518_053350_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey()->unsigned(),
            'feed' => $this->integer()->unsigned()->notNull(),
            'published_at' => $this->dateTime()->notNull(),
            'title' => $this->string(255)->notNull(),
            'short_text' => $this->string(255)->notNull(),
            'external_uri' => $this->string(255)->notNull(),
            'read' => $this->boolean()->unsigned()->notNull()->defaultValue(0)
        ]);

        $this->addForeignKey('feed', 'news', 'feed', 'feeds', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        return false;
    }
}
