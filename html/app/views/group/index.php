<?php

use app\components\group\GroupComponent;
use app\models\Group;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\web\View;

/** @var $this View */
/** @var $data ActiveDataProvider */
/** @var $helper GroupComponent */

?>

<div class="panel">
    <div class="panel-heading ta">
        <div class="panel-control">
            <div class="btn-group btn-group-sm pull-right">
                <a href="/group/create">
                    <button class="btn btn-primary">Создать группу</button>
                </a>
            </div>
        </div>
        <div class="panel-title">Группы</div>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $data,
            'summary' => false,
            'tableOptions' => ['class' => 'table table-condensed'],
            'columns' => [
                ['class' => SerialColumn::className()],
                [
                    'label' => 'Название группы',
                    'value' => 'name',
                ],
                [
                    'label' => 'Администратор',
                    'value' => 'admin.username',
                ],
                [
                    'content' => function (Group $group) use ($helper) {
                        $buttons = [];

                        if ($helper->inGroup($group, Yii::$app->user->identity)) {
                            if ($helper->isAdmin($group, Yii::$app->user->identity)) {
                                $buttons[] = Html::a('Просмотр', ['view', 'id' => $group->id], ['class' => 'btn btn-xs btn-info']);
                                $buttons[] = Html::a('Управление', ['edit', 'id' => $group->id], ['class' => 'btn btn-xs btn-success']);
                                $buttons[] = Html::a('Удалить', ['delete', 'id' => $group->id], ['class' => 'btn btn-xs btn-danger', 'data' => [
                                    'confirm' => 'Вы действительно хотите удалить группу?',
                                    'method' => 'post',
                                ],]);
                            } else if ($helper->hasAccess($group, Yii::$app->user->identity)) {
                                $buttons[] = Html::a('Просмотр', ['view', 'id' => $group->id], ['class' => 'btn btn-xs btn-info']);
                                $buttons[] = Html::a('Покинуть', ['exit', 'id' => $group->id], ['class' => 'btn btn-xs btn-warning', 'data' => [
                                    'confirm' => 'Вы действительно хотите покинуть группу?',
                                    'method' => 'post',
                                ],]);
                            } else {
                                $buttons[] = Html::tag('span', 'Вы отправили заявку', ['class' => 'btn btn-xs btn-info']);
                            }
                        } else {
                            $buttons[] = Html::a('Вступить', ['request', 'id' => $group->id], ['class' => 'btn btn-xs btn-success']);
                        }

                        return Html::tag('div', implode(' ', $buttons), ['class' => 'pull-right']);
                    }
                ]
            ]
        ]) ?>
    </div>
</div>
