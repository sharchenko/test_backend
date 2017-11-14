<?php

use yii\db\Migration;

/**
 * Class m171114_210409_order
 */
class m171114_210409_order extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'dish_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('order_user_fk', 'order', 'user_id', 'user', 'id', 'cascade');
        $this->addForeignKey('order_dish_fk', 'order', 'dish_id', 'dish', 'id', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}
