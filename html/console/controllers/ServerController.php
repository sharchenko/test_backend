<?php


namespace console\controllers;


use common\models\User;
use consik\yii2websocket\events\WSClientErrorEvent;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\events\WSClientMessageEvent;
use console\daemons\WebSocketServer;
use yii\console\Controller;
use yii\helpers\Json;

class ServerController extends Controller
{
    public function actionIndex($port = 81)
    {
        $server = new WebSocketServer();
        $server->port = $port;

        $storage = new \SplObjectStorage();

        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN, function () use ($server) {
            echo "Server started at port " . $server->port;
        });

        $server->on(WebSocketServer::EVENT_CLIENT_CONNECTED, function (WSClientEvent $event) {
        });

        $server->on(WebSocketServer::EVENT_CLIENT_ERROR, function (WSClientErrorEvent $event) {
            echo $event->exception->getTraceAsString() . PHP_EOL;
            echo $event->exception->getMessage() . PHP_EOL;
        });

        $server->on(WebSocketServer::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $event) use ($storage) {
            $message = Json::decode($event->message);

            if ($storage->contains($event->client)) {
                /** @var User $user */
                $user = $storage->offsetGet($event->client);
            } else {
                if (isset($message['auth'])) {
                    if ($user = User::findOne(['auth_key' => $message['auth']])) {
                        $event->client->send(Json::encode([
                            'auth' => 'success'
                        ]));
                        $storage->attach($event->client, $user);
                    } else {
                        $event->client->send(Json::encode([
                            'auth' => 'invalid key'
                        ]));
                        $event->client->close();
                        return;
                    }
                }
            }
            echo 'message by ' . $user->username . PHP_EOL;
            $event->client->send($event->message);
        });

        $server->start();
    }
}