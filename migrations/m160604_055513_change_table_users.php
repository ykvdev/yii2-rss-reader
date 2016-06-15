<?php

use yii\db\Migration;

class m160604_055513_change_table_users extends Migration
{
    public function up()
    {
        $this->renameColumn('users', 'activated', 'confirmed');
    }

    public function down()
    {
        echo "m160604_055513_change_table_users cannot be reverted.\n";

        return false;
    }
}
