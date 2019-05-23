<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_followers".
 *
 * @property integer $id
 * @property integer $follower_id
 * @property integer $follow_up_id
 * @property string $datetime
 *
 * @property Users $follower
 * @property Users $followUp
 */
class UsersFollowers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_followers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['follower_id', 'follow_up_id', 'datetime'], 'required'],
            [['follower_id', 'follow_up_id'], 'integer'],
            [['datetime'], 'safe'],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['follower_id' => 'id']],
            [['follow_up_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['follow_up_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'follower_id' => Yii::t('base', 'Follower ID'),
            'follow_up_id' => Yii::t('base', 'Follow Up ID'),
            'datetime' => Yii::t('base', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne(Users::className(), ['id' => 'follower_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowUp()
    {
        return $this->hasOne(Users::className(), ['id' => 'follow_up_id']);
    }
}
