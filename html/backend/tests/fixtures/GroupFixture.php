<?php


namespace backend\tests\fixtures;


use yii\test\ActiveFixture;

class GroupFixture extends ActiveFixture
{
    public $modelClass = 'backend\models\Group';

    public $depends = [
        'backend\tests\fixtures\UserFixture'
    ];
}