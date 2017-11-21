<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dish */

$this->title = 'Новое блюдо';
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index', 'category' => $model->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
