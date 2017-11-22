<?php


namespace console\daemons;


use yii\base\BaseObject;

/**
 * Class Room
 * @package console\daemons
 */
class Room extends BaseObject
{
    /** @var  \SplObjectStorage */
    public $clients;

    /** @var  \backend\models\Group */
    public $group;

    public function init()
    {
        $this->clients = new \SplObjectStorage();
    }
}