<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $dish_id
 * @property integer $count
 * @property integer $created_at
 *
 * @property Dish $dish
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'dish_id', 'count', 'created_at'], 'required'],
            [['order_id', 'user_id', 'dish_id', 'count', 'created_at'], 'integer'],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dish::className(), 'targetAttribute' => ['dish_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'dish_id' => 'Dish ID',
            'count' => 'Count',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dish::className(), ['id' => 'dish_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\OrderQuery(get_called_class());
    }
}
