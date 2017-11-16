<?php


namespace app\components\basket;


use app\models\Dish;
use app\models\Order;
use app\models\OrderDishes;
use common\models\User;
use yii\base\Component;
use yii\helpers\Json;

/**
 * Class BasketComponent
 * @package app\components\basket
 *
 * @property Order $order
 * @property integer $orderCount
 */
class BasketComponent extends Component
{
    /** @var  Order */
    private $_order;

    public function getOrder()
    {
        if (!isset($this->_order)) {
            $order = Order::find()->currentDraft(\Yii::$app->user->id);
            if (!$order) {
                $order = new Order([
                    'status' => Order::STATUS_DRAFT
                ]);
                if (!$order->save()) {
                    throw new \LogicException(Json::encode($order->errors));
                }
            }
            $this->_order = $order;
        }

        return $this->_order;
    }

    public function getOrderCount() {
        return $this->order->getOrderDishes()->count();
    }

    public function append(Dish $dish, User $user = null)
    {
        if (!$user) $user = \Yii::$app->user->identity;

        if (OrderDishes::findOne([
            'order_id' => $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ])) return false;

        $orderDish = new OrderDishes([
            'order_id' => $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
            'count' => 1
        ]);

        return $orderDish->save();
    }

    public function remove(Dish $dish, User $user = null)
    {
        if (!$user) $user = \Yii::$app->user->identity;

        \Yii::warning([
            'order_id' => $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ]);

        if ($orderDish = OrderDishes::findOne([
            'order_id' => $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ])) {
            if ($orderDish->delete()) return true;
        }
        return false;
    }

    public function setCount(Dish $dish, $count, User $user = null)
    {
        if (!$user) $user = \Yii::$app->user->identity;

        if ($orderDish = OrderDishes::findOne([
            'order_id' => $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ])) {
            $orderDish->count = $count;
            if ($orderDish->save()) return true;
        }
        return false;
    }
}