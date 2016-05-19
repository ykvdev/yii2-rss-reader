<?php

use yii\db\Migration;

class m160519_052447_add_unique_indexes extends Migration
{
    public function up()
    {
        $this->createIndex('user,site_url,rss_uri-unique', 'feeds', ['user', 'site_url', 'rss_uri'], true);

        $this->createIndex('feed,title-unique', 'news', ['feed', 'title'], true);
        $this->createIndex('feed,external_uri-unique', 'news', ['feed', 'external_uri'], true);

        $this->createIndex('email-unique', 'users', 'email', true);
    }

    public function down()
    {
        return false;
    }
}
