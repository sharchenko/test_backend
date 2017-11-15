<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index', 'category' => $model->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить данное блюдо?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'price',
            [
                'label' => 'Категория',
                'value' => $model->category->name
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
