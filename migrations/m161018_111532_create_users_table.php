<?php

use yii\db\Migration;

/**
 * Handles the creation for table `users`.
 */
class m161018_111532_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id'       => $this->primaryKey(),
            'login'    => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'email'    => $this->string(255)->notNull()->unique()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
