<?php


namespace backend\controllers;


use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAuthKey()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (($key = Yii::$app->session->get('auth_key')) && $key === Yii::$app->user->identity->auth_key) {
            return ['key' => $key];
        } else {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->save(false);
            Yii::$app->session->set('auth_key', $user->auth_key);
            return ['key' => $user->auth_key];
        }
    }
}