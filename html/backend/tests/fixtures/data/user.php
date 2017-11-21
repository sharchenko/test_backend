<?php

use common\models\User;

$data = [];
$password = '123456';

for ($i = 0; $i < 50; ++$i) {
    $data[$i] = [
        'username' => "TestUser$i",
        'password_hash' => Yii::$app->security->generatePasswordHash($password),
        'email' => "test$i@mail.com",
        'status' => User::STATUS_ACTIVE,
        'created_at' => time(),
        'updated_at' => time(),
        'role' => $i ? User::ROLE_USER : User::ROLE_ADMIN,
        'auth_key' => Yii::$app->security->generateRandomString()
    ];
}

return $data;