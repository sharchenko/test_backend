<?php

use backend\models\Group;
use backend\models\GroupUser;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $group Group */

?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-control">
            <div class="pull-right">
                <?= Html::a('Удалить группу', ['delete', 'id' => $group->id], ['class' => 'btn btn-sm btn-danger', 'data' => [
                    'confirm' => 'Вы действительно хотите удалить группу?',
                    'method' => 'post',
                ],]); ?>
            </div>
        </div>
        <div class="panel-title">
            <h2><?= Html::encode($group->name) ?></h2>
        </div>
    </div>
    <div class="panel-body">
        <h4>Пользователи</h4>
        <?= GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $group->getGroupUsers()
                    ->with('user')
                    ->andWhere(['not', ['user_id' => $group->created_by]])
                    ->orderBy('user_id'),
            ]),
            'summary' => false,
            'tableOptions' => ['class' => 'table table-condensed'],
            'columns' => [
                ['class' => SerialColumn::className()],
                [
                    'label' => 'Имя',
                    'value' => 'user.username'
                ],
                [
                    'label' => 'Email',
                    'value' => 'user.email'
                ],
                [
                    'label' => 'Статус',
                    'content' => function (GroupUser $groupUser) {
                        return $groupUser->status === GroupUser::STATUS_PENDING ?
                            Html::tag('span', 'Отправил запрос', [
                                'class' => 'label label-default'
                            ]) :
                            Html::tag('span', 'В группе', [
                                'class' => 'label label-success'
                            ]);
                    }
                ],
                [
                    'content' => function (GroupUser $groupUser) use ($group) {
                        $buttons = [];

                        if ($groupUser->status === GroupUser::STATUS_PENDING) {
                            $buttons[] = Html::a('Подтвердить', ['approve', 'group_id' => $group->id, 'user_id' => $groupUser->user_id], ['class' => 'btn btn-xs btn-info']);
                            $buttons[] = Html::a('Отклонить', ['execute', 'group_id' => $group->id, 'user_id' => $groupUser->user_id], ['class' => 'btn btn-xs btn-warning', 'data' => [
                                'confirm' => "Вы действительно хотите отклонить пользователя {$groupUser->user->username}?",
                                'method' => 'post',
                            ]]);
                        } else {
                            $buttons[] = Html::a('Исключить', ['execute', 'group_id' => $group->id, 'user_id' => $groupUser->user_id], ['class' => 'btn btn-xs btn-danger', 'data' => [
                                'confirm' => "Вы действительно хотите исключить пользователя {$groupUser->user->username} из группы?",
                                'method' => 'post',
                            ]]);
                        }

                        return implode(' ', $buttons);
                    }
                ]
            ]
        ]) ?>
    </div>
</div>
