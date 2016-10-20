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
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'token' => $this->string(),
            'status' => $this->string()->notNull()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
