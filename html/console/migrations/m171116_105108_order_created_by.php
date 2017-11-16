<?php

use yii\db\Migration;

/**
 * Class m171116_105108_order_created_by
 */
class m171116_105108_order_created_by extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('order', 'created_by', $this->integer());
        $this->addForeignKey('order_creator_fk', 'order', 'created_by', 'user', 'id', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'created_by');
    }
}
