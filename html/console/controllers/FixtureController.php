<?php


namespace console\controllers;


class FixtureController extends \yii\console\controllers\FixtureController
{
    public function init()
    {
        \Yii::setAlias('@app', dirname(dirname(__DIR__)) . '/app'); //TODO консольный контроллер переопределяет @app, на будущее исполльщовать другое пространство имен
        parent::init();
    }
}