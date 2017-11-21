<?php


namespace backend\components\basket;


use backend\models\Dish;
use backend\models\Group;
use backend\models\Order;
use backend\models\OrderDishes;
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

    /**
     * @return Order|null
     */
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

    public function getGroupOrder(Group $group)
    {
        $order = Order::find()->currentGroupDraft($group->id);
        if (!$order) {
            $order = new Order([
                'status' => Order::STATUS_DRAFT,
                'group_id' => $group->id,
                'created_by' => $group->created_by
            ]);
            if (!$order->save()) {
                throw new \LogicException(Json::encode($order->errors));
            }
        }
        return $order;
    }

    /**
     * @return int|string
     */
    public function getOrderCount()
    {
        return $this->order->getOrderDishes()->count();
    }

    /**
     * @param Dish $dish
     * @param User|null $user
     * @param Order|null $order
     * @return bool
     */
    public function append(Dish $dish, User $user = null, Order $order = null)
    {
        if (!$user) $user = \Yii::$app->user->identity;

        if (OrderDishes::findOne([
            'order_id' => $order ? $order->id : $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ])) return false;

        $orderDish = new OrderDishes([
            'order_id' => $order ? $order->id : $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
            'count' => 1
        ]);

        return $orderDish->save();
    }

    /**
     * @param Dish $dish
     * @param User|null $user
     * @param Order|null $order
     * @return bool
     */
    public function remove(Dish $dish, User $user = null, Order $order = null)
    {
        if (!$user) $user = \Yii::$app->user->identity;

        if ($orderDish = OrderDishes::findOne([
            'order_id' => $order ? $order->id : $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ])) {
            if ($orderDish->delete()) return true;
        }
        return false;
    }

    /**
     * @param Dish $dish
     * @param $count
     * @param User|null $user
     * @param Order|null $order
     * @return bool
     */
    public function setCount(Dish $dish, $count, User $user = null, Order $order = null)
    {
        if (!$user) $user = \Yii::$app->user->identity;

        if ($orderDish = OrderDishes::findOne([
            'order_id' => $order ? $order->id : $this->order->id,
            'user_id' => $user->id,
            'dish_id' => $dish->id,
        ])) {
            $orderDish->count = $count;
            if ($orderDish->save()) return true;
        }
        return false;
    }
}