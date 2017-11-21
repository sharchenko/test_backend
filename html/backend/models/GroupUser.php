<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "group_user".
 *
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $status
 *
 * @property Group $group
 * @property User $user
 */
class GroupUser extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';

    public static function create(Group $group, User $user = null, $status = self::STATUS_PENDING)
    {
        if (!$user) $user = Yii::$app->user->identity;

        $instance = new GroupUser([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'status' => $status
        ]);
        $instance->save();
        return $instance;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id', 'status'], 'required'],
            [['group_id', 'user_id'], 'integer'],
            ['status', 'string'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\GroupUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\GroupUserQuery(get_called_class());
    }
}
