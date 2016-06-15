<?php

use yii\db\Migration;

class m160615_132711_change_column extends Migration
{
    public function up()
    {
        $this->renameColumn('users_security', 'confirm_hash', 'confirmation_hash');
    }

    public function down()
    {
        echo "m160615_132711_change_column cannot be reverted.\n";

        return false;
    }
}
