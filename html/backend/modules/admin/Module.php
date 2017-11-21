<?php

namespace backend\modules\admin;

use common\models\User;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    public $layoutPath = '@app/modules/admin/views/layouts';
    public $layout = 'main';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        $isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->role === User::ROLE_ADMIN;
        if (!$isAdmin) throw new ForbiddenHttpException();

        return parent::beforeAction($action);
    }
}
