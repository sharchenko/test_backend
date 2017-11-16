<?php

namespace app\models\queries;
use app\models\Order;

/**
 * This is the ActiveQuery class for [[\app\models\Order]].
 *
 * @see \app\models\Order
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
     * @inheritdoc
     * @return \app\models\Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
