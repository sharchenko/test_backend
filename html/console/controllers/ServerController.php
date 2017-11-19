<?php


namespace console\controllers;


use common\models\User;
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

        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN, function() use($server) {
            echo "Server started at port " . $server->port;
        });

        $server->on(WebSocketServer::EVENT_CLIENT_CONNECTED, function (WSClientEvent $event) {
        });

        $server->on(WebSocketServer::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $event) {
            $message = Json::decode($event->message);

            if (isset($message['auth'])) {
                if (User::findOne(['auth_key' => $message['auth']])) {
                    $event->client->send(Json::encode([
                        'auth' => 'success'
                    ]));
                } else {
                    $event->client->send(Json::encode([
                        'auth' => 'invalid key'
                    ]));
                    $event->client->close();
                }
            }
            $event->client->close();
        });

        $server->start();
    }
}