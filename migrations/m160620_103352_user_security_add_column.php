<?php

use yii\db\Migration;

class m160620_103352_user_security_add_column extends Migration
{
    public function up()
    {
        $this->addColumn(
            'users_security',
            'hash_id',
            $this->string(32)->unique()->notNull()->after('user')
        );
    }

    public function down()
    {
        echo "m160620_103352_user_security_add_column cannot be reverted.\n";

        return false;
    }
}
