<?php

use yii\db\Migration;

/**
 * Handles the creation for table `users`.
 */
class m160518_050408_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey()->unsigned(),
            'email' => $this->string(50)->notNull(),
            'password' => $this->string(255)->notNull(),
            'registered_at' => $this->dateTime()->notNull(),
            'activated' => $this->boolean()->defaultValue(0)->notNull()->unsigned()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        return false;
    }
}
