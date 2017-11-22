<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = "Заказ #$model->id";
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel">
        <div class="panel-body">
            <p>
                Отправитель:
                <strong><?= Html::encode(ArrayHelper::getValue($model, 'sender.username') ?: ArrayHelper::getValue($model, 'group.name')) ?></strong>
            </p>
            <?php if ($model->sender): ?>
                <p>
                    Email: <a
                            href="mailto:<?= Html::encode($model->sender->email) ?>"><?= Html::encode($model->sender->email) ?></a>
                </p>
            <?php endif; ?>
            <hr>
            <h4>Содержание</h4>
            <table class="table table-responsive table-condensed">
                <?php $total = 0 ?>
                <?php foreach ($model->orderDishes as $orderDish): ?>
                    <?php $total += $orderDish->count * $orderDish->dish->price ?>
                    <tr>
                        <td><?= $orderDish->dish->name ?></td>
                        <td><?= $orderDish->count ?>
                            x <?= Yii::$app->formatter->asCurrency($orderDish->dish->price) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" class="text-right">
                        <strong>Всего:</strong> <?= Yii::$app->formatter->asCurrency($total) ?></td>
                </tr>
            </table>
        </div>
    </div>

</div>
