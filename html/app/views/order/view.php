<?php

use app\models\OrderDishes;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $models OrderDishes[] */

?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-title"><h2>Ваш заказ</h2></div>
    </div>
    <div class="panel-body">
        <?php if (count($models)): ?>
            <table class="table table-responsive table-condensed">
                <?php foreach ($models as $dish): ?>
                    <tr>
                        <td>
                            <?= Html::encode($dish->dish->name) ?>
                            <div>
                                <small>
                                    <?= Html::encode($dish->dish->description) ?>
                                </small>
                            </div>
                        </td>
                        <td class="price"><?= Yii::$app->formatter->asCurrency($dish->dish->price * $dish->count) ?></td>
                        <td style="min-width: 80px;">
                            <div class="btn-group btn-group-xs">
                                <button class="btn" data-action="changeCount" data-type="decrement"
                                        data-id="<?= $dish->dish->id ?>">-
                                </button>
                                <button class="btn btn-primary"><strong class="count"><?= $dish->count ?></strong>
                                </button>
                                <button class="btn" data-action="changeCount" data-type="increment"
                                        data-id="<?= $dish->dish->id ?>">+
                                </button>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger" data-action="remove" data-id="<?= $dish->dish->id ?>">
                                Удалить
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <a href="/order/send" class="clearfix">
                <button class="btn btn-primary pull-right">Отправить заказ</button>
            </a>
        <?php else: ?>
            <h4>Вы еще ничего не заказали, перейдите в <a href="/">меню</a>, чтобы сделать заказ.</h4>
        <?php endif; ?>
    </div>
    <div class="panel-footer"></div>
</div>