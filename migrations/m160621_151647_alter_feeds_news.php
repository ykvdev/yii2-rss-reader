<?php

use yii\db\Migration;

class m160621_151647_alter_feeds_news extends Migration
{
    public function up()
    {
        $this->renameColumn('feeds', 'site_url', 'url');
        $this->renameColumn('feeds', 'rss_uri', 'title');
        $this->renameColumn('news', 'external_uri', 'url');
    }

    public function down()
    {
        echo "m160621_151647_alter_feeds_news cannot be reverted.\n";

        return false;
    }
}
