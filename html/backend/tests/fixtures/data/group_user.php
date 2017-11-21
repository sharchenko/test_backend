<?php

use backend\models\Group;
use backend\models\GroupUser;
use common\models\User;
use Faker\Factory;

$faker = Factory::create();
$data = [];

foreach (User::find()->all() as $user) {
    foreach (Group::find()->all() as $group) {
        if ($group->created_by == $user->id) {
            $data[] = [
                'user_id' => $user->id,
                'group_id' => $group->id,
                'status' => GroupUser::STATUS_APPROVED
            ];
        } else {
            if ($faker->randomNumber() % 3 !== 0) {
                $data[] = [
                    'user_id' => $user->id,
                    'group_id' => $group->id,
                    'status' => $faker->randomNumber() % 3 !== 0 ? GroupUser::STATUS_APPROVED : GroupUser::STATUS_PENDING
                ];
            }
        }
    }
}

return $data;