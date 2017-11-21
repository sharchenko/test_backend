<?php


namespace backend\tests\fixtures;


use yii\test\ActiveFixture;

class DishFixture extends ActiveFixture
{

    public $modelClass = 'app\models\Dish';

    public $depends = [
        'app\tests\fixtures\CategoryFixture'
    ];

}