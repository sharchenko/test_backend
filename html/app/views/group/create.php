<?php

use app\models\Group;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\View;

/** @var $this View */
/** @var $model Group */

?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">Новая группа</div>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Создать группу', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

        <?php $form::end() ?>
    </div>
</div>
