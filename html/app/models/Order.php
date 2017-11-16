<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $sender
 * @property OrderDishes[] $orderDishes
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 'draft';
    const STATUS_SENT = 'sent';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
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
            [['status'], 'required'],
            [['created_by', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $modelWasSent = $this->status === self::STATUS_SENT && $changedAttributes['status'] === self::STATUS_DRAFT;

        if ($modelWasSent) OrderHistory::write($this);
    }

    public function send() {
        $this->status = self::STATUS_SENT;
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status ID',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDishes()
    {
        return $this->hasMany(OrderDishes::className(), ['order_id' => 'id'])->orderBy('id');
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\OrderQuery(get_called_class());
    }
}
