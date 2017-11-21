<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "order_history".
 *
 * @property integer $id
 * @property string $order
 * @property integer $created_at
 */
class OrderHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_history';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order'], 'string'],
            [['created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => 'Order',
            'created_at' => 'Created At',
        ];
    }

    public static function write(Order $order)
    {
        $orderData = $order->toArray();
        $orderData['dishes'] = $order->getOrderDishes()->with('dish')->asArray()->all();
        return (new self(['order' => Json::encode($orderData)]))->save();
    }
}
