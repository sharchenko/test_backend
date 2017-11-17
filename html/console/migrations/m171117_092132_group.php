<?php

use yii\db\Migration;

/**
 * Class m171117_092132_group
 */
class m171117_092132_group extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('group', [
            'id' => $this->primaryKey(),
            'created_by' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('group_creator_fk', 'group', 'created_by', 'user', 'id', 'cascade');

        $this->createTable('group_user', [
            'group_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('group_user_pk', 'group_user', ['group_id', 'user_id']);
        $this->addForeignKey('group_user_fk', 'group_user', 'user_id', 'user', 'id', 'cascade');
        $this->addForeignKey('group_fk', 'group_user', 'group_id', 'group', 'id', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('group_user');
        $this->dropTable('group');
    }
}
