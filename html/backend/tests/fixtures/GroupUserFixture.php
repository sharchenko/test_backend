<?php


namespace backend\tests\fixtures;


use yii\test\ActiveFixture;

class GroupUserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\GroupUser';

    public $depends = [
        'app\tests\fixtures\GroupFixture'
    ];
}