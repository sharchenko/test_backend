<?php

use backend\models\Group;
use backend\models\GroupUser;
use yii\base\Event;

Event::on(Group::className(), Group::EVENT_AFTER_INSERT, function(Event $event) {
    /** @var Group $group */
    $group = $event->sender;
    GroupUser::create($group, null, GroupUser::STATUS_APPROVED);
});