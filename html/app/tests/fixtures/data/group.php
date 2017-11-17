<?php

use common\models\User;
use Faker\Factory;

$faker = Factory::create();
$data = [];

foreach (User::find()->all() as $user) {
    $data[] = [
        'name' => $faker->sentence(3),
        'created_by' => $user->id
    ];
}

return $data;