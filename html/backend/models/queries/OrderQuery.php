<?php

namespace backend\models\queries;

use backend\models\Order;

/**
 * This is the ActiveQuery class for [[\app\models\Order]].
 *
 * @see \backend\models\Order
 */
class OrderQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $id
     * @return Order|null
     */
    public function currentDraft($id)
    {
        return $this
            ->andWhere(['created_by' => $id])
            ->andWhere(['status' => Order::STATUS_DRAFT])
            ->one();
    }

    /**
     * @param $id
     * @return Order|null
     */
    public function currentGroupDraft($id)
    {
        return $this
            ->andWhere(['group_id' => $id])
            ->andWhere(['status' => Order::STATUS_DRAFT])
            ->one();
    }

    /**
     * @inheritdoc
     * @return \backend\models\Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
