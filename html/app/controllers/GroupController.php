<?php


namespace app\controllers;


use app\components\group\GroupComponent;
use app\models\Group;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class GroupController extends Controller
{
    /** @var  GroupComponent */
    public $helper;

    public function init()
    {
        $this->helper = Yii::$app->group;
        parent::init();
    }

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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Group::find()
                ->with('groupUsersApproved')
                ->with('groupUsersPending')
                ->orderBy('id DESC'),
        ]);

        return $this->render('index', [
            'data' => $dataProvider,
            'helper' => $this->helper
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Group();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->save()) return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        if ($this->helper->remove($id)) {
            Yii::$app->session->setFlash('success', 'Группа удалена');
            return $this->redirect(['index']);
        }

        return $this->setWarningAndRedirect();
    }

    public function actionView($id)
    {
        $group = $this->helper->findGroup($id);

        return $this->render('view', [
            'group' => $group
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $group = $this->helper->findGroup($id);
        $this->helper->canEditOrError($group, Yii::$app->user->identity);

        return $this->render('edit', [
            'group' => $group
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionRequest($id)
    {
        if (!$this->helper->joinRequest($id)->hasErrors()) {
            Yii::$app->session->setFlash('success', 'Запрос отправлен');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->setWarningAndRedirect();
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionExit($id)
    {
        if ($this->helper->removeUser($id, Yii::$app->user->id)) {
            Yii::$app->session->setFlash('success', 'Вы вышли из группы');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->setWarningAndRedirect();
    }

    /**
     * @param $group_id
     * @param $user_id
     * @return \yii\web\Response
     */
    public function actionExecute($group_id, $user_id)
    {
        $group = $this->helper->findGroup($group_id);
        $this->helper->canEditOrError($group, Yii::$app->user->identity);

        if ($this->helper->removeUser($group_id, $user_id)) {
            Yii::$app->session->setFlash('success', 'Пользователь исключен из группы');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->setWarningAndRedirect();
    }

    /**
     * @param $group_id
     * @param $user_id
     * @return \yii\web\Response
     */
    public function actionApprove($group_id, $user_id)
    {
        $group = $this->helper->findGroup($group_id);
        $this->helper->canEditOrError($group, Yii::$app->user->identity);

        if ($this->helper->joinUser($group_id, $user_id)) {
            Yii::$app->session->setFlash('success', 'Пользователь подтвержден');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->setWarningAndRedirect();
    }

    /**
     * @param string $message
     * @param null $route
     * @return \yii\web\Response
     */
    private function setWarningAndRedirect($message = 'Произошла ошибка.', $route = null) {
        if (!$route) $route = Yii::$app->request->referrer;

        Yii::$app->session->setFlash('warning', $message);

        return $this->redirect($route);
    }
}