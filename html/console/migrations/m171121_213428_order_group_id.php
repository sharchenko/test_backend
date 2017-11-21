<?php

use yii\db\Migration;

/**
 * Class m171121_213428_order_group_id
 */
class m171121_213428_order_group_id extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('order', 'group_id', $this->integer());
        $this->addForeignKey('order_group_fk', 'order', 'group_id', 'group', 'id', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'group_id');
    }

}
