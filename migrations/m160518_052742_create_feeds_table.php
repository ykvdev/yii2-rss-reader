<?php

use yii\db\Migration;

/**
 * Handles the creation for table `feeds`.
 */
class m160518_052742_create_feeds_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('feeds', [
            'id' => $this->primaryKey()->unsigned(),
            'user' => $this->integer()->unsigned()->notNull(),
            'site_url' => $this->string(255)->notNull(),
            'rss_uri' => $this->string(255)->notNull(),
            'subscribed_at' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey('user', 'feeds', 'user', 'users', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        return false;
    }
}
