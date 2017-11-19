<?php


namespace console\controllers;


use console\daemons\WebSocketServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionIndex($port = 81)
    {
        $server = new WebSocketServer();
        $server->port = $port;
        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN, function($e) use($server) {
            echo "Server started at port " . $server->port;
        });

        $server->start();
    }
}