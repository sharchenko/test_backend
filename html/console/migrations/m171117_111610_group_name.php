<?php

use yii\db\Migration;

/**
 * Class m171117_111610_group_name
 */
class m171117_111610_group_name extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('group' ,'name', $this->string()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('group' ,'name');
    }

}
