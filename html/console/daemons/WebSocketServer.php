<?php


namespace console\daemons;

use backend\components\group\GroupComponent;
use backend\models\Category;
use backend\models\Dish;
use backend\models\Group;
use common\models\User;
use Ratchet\ConnectionInterface;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


class WebSocketServer extends \consik\yii2websocket\WebSocketServer
{
    /** @var  Room[] */
    private $rooms = [];

    /** @var  GroupComponent */
    public $helper;

    public function init()
    {
        parent::init();
        $this->helper = new GroupComponent();
    }

    /**
     * @param $id
     * @return Room
     * @throws NotFoundHttpException
     */
    public function getGroup($id)
    {
        new Dish();
        if (key_exists($id, $this->rooms)) {
            return $this->rooms[$id];
        } else {
            if ($model = Group::findOne($id)) {
                $this->rooms[$id] = new Room([
                    'model' => $model
                ]);
                return $this->rooms[$id];
            } else {
                throw new NotFoundHttpException();
            }
        }
    }

    /**
     * @param $params
     * @return User
     * @throws ForbiddenHttpException
     */
    public function getUser($params)
    {
        list($event, $message, $room) = $params;
        $user = null;
        if ($room->storage->contains($event->client)) {
            /** @var User $user */
            $user = $room->storage->offsetGet($event->client);
        } else {
            if (isset($message['auth'])) {
                if ($user = User::findOne(['auth_key' => $message['auth']])) {
                    $event->client->send(Json::encode([
                        'auth' => 'success',
                        'menu' => $this->getMenu()
                    ]));
                    $room->storage->attach($event->client, $user);
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

    public function data()
    {
        return ['menu' => $this->getMenu(), 'time' => date('H:i:s')];
    }

    public function updateData(Room $room)
    {
        $room->storage->rewind();
        while ($room->storage->valid()) {
            /** @var ConnectionInterface $conn */
            $conn = $room->storage->current();
            $user = $room->storage->getInfo();
            if ($this->helper->inGroup($room->model, $user)) {
                $conn->send(Json::encode($this->data()));
            } else {
                $room->storage->detach($conn);
                $conn->close();
            }
            $room->storage->next();
        }
    }

    public function helloWorld(ConnectionInterface $conn, User $user, $params = [])
    {
        $conn->send(Json::encode(['menu' => $this->getMenu(), 'time' => date('H:i:s')]));
    }
}