<?php

use backend\models\Category;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models Category[] */
/* @var $inOrder array */

?>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title"><h2>Меню</h2></div>
        <?php if (Yii::$app->user->isGuest): ?>
            <div>
                <small>Войдите чтобы сделать заказ</small>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php foreach ($models as $category): ?>
            <div class="row">
                <div class="col-md-12">
                    <h3><?= Html::encode($category->name) ?></h3>
                </div>
                <div class="col-md-11 col-md-offset-1">
                    <table class="table table-responsive">
                        <?php foreach ($category->dishes as $dish): ?>
                            <tr>
                                <td>
                                    <?= Html::encode($dish->name) ?>
                                    <div>
                                        <small>
                                            <?= Html::encode($dish->description) ?>
                                        </small>
                                    </div>
                                </td>
                                <td><?= Yii::$app->formatter->asCurrency($dish->price) ?></td>
                                <td>
                                    <?php if (!Yii::$app->user->isGuest && !in_array($dish->id, $inOrder)): ?>
                                        <button class="btn btn-sm btn-primary" data-action="append" data-id="<?= $dish->id ?>">Добавить
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
