<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m171114_202307_user_group
 */
class m171114_202307_user_role extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->string('5')->defaultValue(User::ROLE_USER));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }
}
