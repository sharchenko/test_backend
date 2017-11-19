<?php


namespace console\daemons;


use common\models\User;
use Ratchet\ConnectionInterface;
use yii\base\BaseObject;

class GroupMember extends BaseObject
{
    /** @var  User */
    public $user;
    /** @var  ConnectionInterface */
    public $conn;
}