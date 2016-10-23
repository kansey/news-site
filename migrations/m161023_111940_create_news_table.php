<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m161023_111940_create_news_table extends Migration
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

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'body' => $this->text()->notNull(),
            'image' => $this->string()->notNull()->unique(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk_id', 'news', 'created_by', 'users', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
