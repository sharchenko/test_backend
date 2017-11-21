<?php

namespace backend\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\GroupUser]].
 *
 * @see \app\models\GroupUser
 */
class GroupUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\GroupUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\GroupUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
