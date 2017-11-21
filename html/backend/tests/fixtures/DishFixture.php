<?php


namespace backend\tests\fixtures;


use yii\test\ActiveFixture;

class DishFixture extends ActiveFixture
{

    public $modelClass = 'backend\models\Dish';

    public $depends = [
        'backend\tests\fixtures\CategoryFixture'
    ];

}