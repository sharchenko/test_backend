<?php

namespace app\models\queries;

use app\models\Category;

/**
 * This is the ActiveQuery class for [[\app\models\Dish]].
 *
 * @see \app\models\Dish
 */
class DishQuery extends \yii\db\ActiveQuery
{
    public function byCategory($category)
    {
        return $this->andWhere(['category_id' => $category instanceof Category ? $category->id : $category]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Dish[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Dish|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
