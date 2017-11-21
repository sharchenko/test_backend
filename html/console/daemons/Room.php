<?php


namespace console\daemons;


use yii\base\BaseObject;

class Room extends BaseObject
{
    /** @var  \SplObjectStorage */
    public $storage;

    /** @var  \backend\models\Group */
    public $model;

    public function init()
    {
        $this->storage = new \SplObjectStorage();
    }
}