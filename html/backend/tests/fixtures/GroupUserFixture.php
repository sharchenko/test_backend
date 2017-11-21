<?php


namespace backend\tests\fixtures;


use yii\test\ActiveFixture;

class GroupUserFixture extends ActiveFixture
{
    public $modelClass = 'backend\models\GroupUser';

    public $depends = [
        'backend\tests\fixtures\GroupFixture'
    ];
}