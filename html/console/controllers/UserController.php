<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreate($name, $email, $password, $role = 'user')
    {
        $user = new User();
        $user->scenario = User::SCENARIO_CONSOLE;

        $user->username = $name;
        $user->email = $email;
        $user->role = $role;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->validate() && $user->save()) {
            echo 'success' . PHP_EOL;
            return;
        } else {
            var_dump($user->errors);
            echo PHP_EOL;
            return;
        }
    }
}