<?php

use yii\db\Migration;

class m160615_105848_add_unique_indexes extends Migration
{
    public function up()
    {
        $this->createIndex('user-unique', 'users_security', 'user', true);
    }

    public function down()
    {
        echo "m160615_105848_add_unique_indexes cannot be reverted.\n";

        return false;
    }
}
