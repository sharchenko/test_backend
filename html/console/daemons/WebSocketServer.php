<?php


namespace console\daemons;

use backend\components\basket\BasketComponent;
use backend\components\group\GroupComponent;
use backend\models\Category;
use backend\models\Dish;
use backend\models\Group;
use backend\models\Order;
use backend\models\OrderDishes;
use common\models\User;
use Ratchet\ConnectionInterface;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


class WebSocketServer extends \consik\yii2websocket\WebSocketServer
{
    /** @var  Room[] */
    private $rooms = [];

    /** @var  GroupComponent */
    public $groupHelper;
    /** @var  BasketComponent */
    public $basketHelper;


    public function init()
    {
        parent::init();
        $this->groupHelper = new GroupComponent();
        $this->basketHelper = new BasketComponent();
    }

    /**
     * @param $id
     * @return Room
     * @throws NotFoundHttpException
     */
    public function getRoom($id)
    {
        if (key_exists($id, $this->rooms)) {
            return $this->rooms[$id];
        } else {
            if ($group = Group::findOne($id)) {
                $this->rooms[$id] = new Room([
                    'group' => $group
                ]);
                return $this->rooms[$id];
            } else {
                throw new NotFoundHttpException();
            }
        }
    }

    public function disconnect(Room $room, ConnectionInterface $conn, $message = null)
    {
        $conn->send(Json::encode(['error' => $message ?: 'forbidden exception']));
        $room->clients->detach($conn);
        $conn->close();
    }

    /**
     * @param $params
     * @return User
     * @throws ForbiddenHttpException
     */
    public function getUser($params)
    {
        list($event, $message, $room) = $params;
        $order = $this->basketHelper->getGroupOrder($room->group);
        $user = null;
        if ($room->clients->contains($event->client)) {
            /** @var User $user */
            $user = $room->clients->offsetGet($event->client);
        } else {
            if (isset($message['auth'])) {
                if ($user = User::findOne(['auth_key' => $message['auth']])) {
                    $event->client->send(Json::encode(ArrayHelper::merge([
                        'auth' => 'success',
                    ], $this->data($order, $user, $room->group->created_by === $user->id))));
                    $room->clients->attach($event->client, $user);
                } else {
                    $event->client->send(Json::encode([
                        'auth' => 'invalid key'
                    ]));
                    $event->client->close();
                }
            }
        }
        if ($user) {
            return $user;
        } else {
            throw new ForbiddenHttpException();
        }
    }

    public function getMenu()
    {
        return Category::find()
            ->with('dishes')
            ->asArray()
            ->all();
    }

    public function data(Order $order, User $user, $isAdmin)
    {
        return [
            'menu' => $this->getMenu(),
            'selfOrder' => OrderDishes::find()
                ->select([
                    'count',
                    'dish_id',
                    'name',
                    'price'
                ])
                ->andWhere(['order_id' => $order->id])
                ->andWhere(['user_id' => $user->id])
                ->leftJoin('dish', 'dish.id=order_dishes.dish_id')
                ->asArray()
                ->all(),
            'summaryOrder' => (new Query())
                ->select([
                    'count',
                    'dish_id',
                    'name',
                    'price'
                ])
                ->from([
                    'order_dishes' => OrderDishes::find()
                        ->select(['dish_id', 'sum(count) as count'])
                        ->andWhere(['order_id' => $order->id])
                        ->groupBy(['dish_id'])
                ])
                ->leftJoin('dish', 'dish.id=order_dishes.dish_id')
                ->all(),
            'canSend' => $isAdmin
        ];
    }

    public function updateData(Room $room)
    {
        $order = $this->basketHelper->getGroupOrder($room->group);

        $room->clients->rewind();
        while ($room->clients->valid()) {
            /** @var ConnectionInterface $conn */
            $conn = $room->clients->current();
            $user = $room->clients->getInfo();
            if ($this->groupHelper->inGroup($room->group, $user)) {
                $conn->send(Json::encode($this->data($order, $user, $room->group->created_by === $user->id)));
            } else {
                $this->disconnect($room, $conn);
            }
            $room->clients->next();
        }
    }

    public function _append(Room $room, User $user, $params = [])
    {
        if ($dish = Dish::findOne(ArrayHelper::getValue($params, 'dish_id'))) {
            $order = $this->basketHelper->getGroupOrder($room->group);
            return $this->basketHelper->append($dish, $user, $order);
        }
    }

    public function _remove(Room $room, User $user, $params = [])
    {
        if ($dish = Dish::findOne(ArrayHelper::getValue($params, 'dish_id'))) {
            $order = $this->basketHelper->getGroupOrder($room->group);
            return $this->basketHelper->remove($dish, $user, $order);
        }
    }

    public function _increment(Room $room, User $user, $params = [])
    {
        $order = $this->basketHelper->getGroupOrder($room->group);

        if (!$user) $user = \Yii::$app->user->identity;

        if ($orderDish = OrderDishes::findOne([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'dish_id' => ArrayHelper::getValue($params, 'dish_id'),
        ])) {
            $orderDish->count++;
            if ($orderDish->save()) return true;
        }
        return false;
    }

    public function _decrement(Room $room, User $user, $params = [])
    {
        $order = $this->basketHelper->getGroupOrder($room->group);

        if (!$user) $user = \Yii::$app->user->identity;

        if ($orderDish = OrderDishes::findOne([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'dish_id' => ArrayHelper::getValue($params, 'dish_id'),
        ])) {
            $orderDish->count--;
            if ($orderDish->count > 0 && $orderDish->save()) return true;
        }
        return false;
    }
}