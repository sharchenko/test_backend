<?php


namespace app\tests\fixtures;


use yii\test\ActiveFixture;

class GroupFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Group';

    public $depends = [
        'app\tests\fixtures\UserFixture'
    ];
}