<?php


namespace console\controllers;


use consik\yii2websocket\events\WSClientErrorEvent;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\events\WSClientMessageEvent;
use console\daemons\WebSocketServer;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ServerController extends Controller
{
    public function actionIndex($port = 81)
    {
        $server = new WebSocketServer();
        $server->port = $port;

        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN, function () use ($server) {
            echo "Server started at port " . $server->port;
        });

        $server->on(WebSocketServer::EVENT_CLIENT_CONNECTED, function (WSClientEvent $event) {
        });

        $server->on(WebSocketServer::EVENT_CLIENT_ERROR, function (WSClientErrorEvent $event) {
            echo $event->exception->getMessage() . PHP_EOL;
            echo '=================================' . PHP_EOL;
            echo $event->exception->getTraceAsString() . PHP_EOL;
        });

        $server->on(WebSocketServer::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $event) use ($server) {
            $message = Json::decode($event->message);
            $group_id = ArrayHelper::getValue($message, 'group_id');

            if (!$group_id) {
                throw new NotFoundHttpException('group_id not found');
            }

            $room = $server->getRoom($group_id);
            $user = $server->getUser([$event, $message, $room]);

            echo 'request from ' . $user->username . PHP_EOL;

            if (!$server->groupHelper->inGroup($room->group, $user)) {
                return $server->disconnect($room, $event->client);
            }

            $action = ArrayHelper::getValue($message, 'action');
            $actionName = "_$action";

            echo $action . PHP_EOL;

            if ($action && method_exists($server, $actionName) && $server->$actionName($room, $user, ArrayHelper::getValue($message, 'params'))) {
                $server->updateData($room);
            } elseif ($actionName) {
                $event->client->send(Json::encode([
                    'error' => 'invalid action'
                ]));
            }
        });

        $server->start();
    }
}