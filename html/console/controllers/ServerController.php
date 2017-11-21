<?php


namespace console\controllers;


use consik\yii2websocket\events\WSClientErrorEvent;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\events\WSClientMessageEvent;
use console\daemons\WebSocketServer;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
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

            $group = $server->getGroup($group_id);
            $user = $server->getUser([$event, $message, $group]);
            echo 'message by ' . $user->username . PHP_EOL;

            /**
             * Данные которые должны присутствовать в запросе
             * ID группы
             * действите [получить список(меню), добавление, удаление, инкремент элементов]
             * ID блюда для всех, кроме получения списка
             *
             * после действия нужно обновлять данные у всех пользователей включая инициатора действия
             * хранилище должно иметь связь
             *      группы => активные подключения => модели пользователей
             *
             * при этом при доступ к группе надо проверять каждый раз, т.к. пользователь может быть исключен во время просмотра страницы
             */
        });

        $server->start();
    }
}