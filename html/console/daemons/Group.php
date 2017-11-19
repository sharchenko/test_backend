<?php


namespace console\daemons;


use yii\base\BaseObject;

class Group extends BaseObject
{
    /** @var GroupMember[] */
    public $groupMembers = [];
}