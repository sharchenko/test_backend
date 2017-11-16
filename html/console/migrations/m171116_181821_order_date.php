<?php

use yii\db\Migration;

/**
 * Class m171116_181821_order_date
 */
class m171116_181821_order_date extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('order', 'created_at', $this->integer());
        $this->addColumn('order', 'updated_at', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'created_at');
        $this->dropColumn('order', 'updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171116_181821_order_date cannot be reverted.\n";

        return false;
    }
    */
}
