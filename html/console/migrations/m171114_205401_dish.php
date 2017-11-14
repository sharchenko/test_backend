<?php

use yii\db\Migration;

/**
 * Class m171114_205401_dish
 */
class m171114_205401_dish extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->double()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('dish_category_fk', 'dish', 'category_id', 'category', 'id', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('dish');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171114_205401_dish cannot be reverted.\n";

        return false;
    }
    */
}
