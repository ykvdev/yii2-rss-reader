<?php

use yii\db\Migration;

class m160621_152014_alter_feeds_news extends Migration
{
    public function up()
    {
        $this->createIndex('user', 'feeds', 'user');

        $this->dropIndex('user,site_url,rss_uri-unique', 'feeds');
        $this->createIndex('user,url-unique', 'feeds', ['user', 'url'], true);
        $this->createIndex('user,title-unique', 'feeds', ['user', 'title'], true);
    }

    public function down()
    {
        echo "m160621_152014_alter_feeds_news cannot be reverted.\n";

        return false;
    }
}
