<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Event;
use yii\behaviors\BlameableBehavior;

Event::on(Group::className(), Group::EVENT_AFTER_INSERT, function(Event $event) {
    /** @var Group $group */
    $group = $event->sender;
    GroupUser::create($group, null, GroupUser::STATUS_APPROVED);
});

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 *
 * @property User $admin
 * @property GroupUser[] $groupUsers
 * @property GroupUser[] $groupUsersApproved
 * @property GroupUser[] $groupUsersPending
 * @property User[] $users
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => null
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string'],
            [['name'], 'required'],
            [['created_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Created By',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupUsers()
    {
        return $this->hasMany(GroupUser::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupUsersApproved()
    {
        return $this->hasMany(GroupUser::className(), ['group_id' => 'id'])->andWhere(['status' => GroupUser::STATUS_APPROVED]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupUsersPending()
    {
        return $this->hasMany(GroupUser::className(), ['group_id' => 'id'])->andWhere(['status' => GroupUser::STATUS_PENDING]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('group_user', ['group_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\GroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\queries\GroupQuery(get_called_class());
    }
}