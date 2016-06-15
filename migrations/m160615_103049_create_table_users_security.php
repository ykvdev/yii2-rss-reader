<?php

use yii\db\Migration;

class m160615_103049_create_table_users_security extends Migration
{
    public function up()
    {
        $this->createTable('users_security', [
            'user' => $this->integer()->unsigned()->notNull(),
            'confirm_hash' => $this->string(32),
            'confirmed' => $this->boolean()->notNull()->defaultValue(0)->unsigned(),
            'reset_password_hash' => $this->string(32),
            'last_fail_auth_count' => $this->integer(1)->notNull()->defaultValue(0)->unsigned(),
        ]);

        $this->addForeignKey('user_id', 'users_security', 'user', 'users', 'id');

        $this->dropColumn('users', 'confirmed');
    }

    public function down()
    {
        return false;
    }
}
