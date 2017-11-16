<?php

use app\models\Category;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $models Category */

?>
<h2>Меню</h2>
<hr>
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
                            <strong><?= Html::encode($dish->name) ?></strong>
                            <div>
                                <small>
                                    <?= Html::encode($dish->description) ?>
                                </small>
                            </div>
                        </td>
                        <td><?= Yii::$app->formatter->asCurrency($dish->price) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <hr>
        </div>
    </div>
<?php endforeach; ?>

