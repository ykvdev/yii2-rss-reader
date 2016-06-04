<?php

use yii\db\Migration;

class m160604_055513_change_table_users extends Migration
{
    public function up()
    {
        $this->dropColumn('users', 'activated');

        $this->addColumn(
            'users',
            'confirmed',
            $this->boolean()->defaultValue(0)->notNull()->unsigned()
        );
    }

    public function down()
    {
        echo "m160604_055513_change_table_users cannot be reverted.\n";

        return false;
    }
}
