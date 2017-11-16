<?php

use yii\db\Migration;

/**
 * Class m171116_182146_order_history
 */
class m171116_182146_order_history extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('order_history', [
            'id' => $this->primaryKey(),
            'order' => 'json',
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('order_history');
    }
}
