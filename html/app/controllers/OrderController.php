<?php


namespace app\controllers;


use app\components\basket\BasketComponent;
use app\models\Dish;
use app\models\Order;
use app\models\OrderDishes;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class OrderController extends Controller
{
    /** @var  BasketComponent */
    private $basket;

    public function init()
    {
        parent::init();
        $this->basket = \Yii::$app->basket;
        \Yii::$app->response->format = Response::FORMAT_JSON;
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

    public function actionView()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;

        $models = $this->basket->order->getOrderDishes()
            ->with('dish')
            ->all();

        return $this->render('view', [
            'models' => $models
        ]);
    }

    public function actionChangeCount($id, $type)
    {
        /** @var OrderDishes $orderDish */
        $orderDish = $this->basket->order->getOrderDishes()
            ->andWhere(['order_dishes.dish_id' => $id])
            ->one();

        if (!$orderDish) throw new NotFoundHttpException();

        if ($type === 'increment') {
            $orderDish->count++;
        } elseif ($type === 'decrement' && $orderDish->count > 1) {
            $orderDish->count--;
        }
        if ($orderDish->save()) {
            return [
                'status' => true,
                'price' => \Yii::$app->formatter->asCurrency($orderDish->count * $orderDish->dish->price),
                'count' => $orderDish->count
            ];
        }
        throw new ServerErrorHttpException();
    }

    public function actionAppend($id)
    {
        if ($this->basket->append($this->findDish($id))) {
            return [
                'status' => 'successfully',
                'currentCount' => $this->basket->orderCount
            ];
        }
        throw new ServerErrorHttpException();
    }

    public function actionRemove($id)
    {
        if ($this->basket->remove($this->findDish($id))) {
            return [
                'status' => 'successfully',
                'currentCount' => $this->basket->orderCount
            ];
        }
        throw new ServerErrorHttpException();
    }

    public function actionSend()
    {
        $order = Order::find()->currentDraft(\Yii::$app->user->id);
        if ($order) {
            if ($order->orderDishes && $order->send()) {
                \Yii::$app->session->setFlash('success', 'Ваш заказ принят, ожидайте.');
                return $this->redirect('/');
            }
            \Yii::$app->session->setFlash('warning', 'Ваш заказ пуст, выберите блюда из меню.');
            return $this->redirect('/');
        }
        \Yii::$app->session->setFlash('warning', 'Возникла непредвиденная ошибка, простите за неудобства');
        return $this->redirect('/');
    }

    /**
     * @param $id
     * @return null|Dish
     * @throws NotFoundHttpException
     */
    private function findDish($id)
    {
        $model = Dish::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}