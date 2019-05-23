<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type_id
 * @property string $start_date
 * @property string $start_time
 * @property integer $players_count
 * @property integer $amount
 * @property integer $total_amount
 * @property integer $status_id
 * @property string $datetime
 *
 * @property LigsTypes $type
 * @property LigsStatus $status
 * @property LigsGames[] $ligsGames
 * @property LigsPlayers[] $ligsPlayers
 * @property Users[] $players
 */
class Ligs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type_id', 'start_date', 'start_time', 'players_count', 'amount', 'total_amount', 'status_id', 'datetime'], 'required'],
            [['type_id', 'players_count', 'amount', 'total_amount', 'status_id'], 'integer'],
            [['start_date', 'start_time', 'datetime'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsTypes::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'type_id' => Yii::t('app', 'Type ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'start_time' => Yii::t('app', 'Start Time'),
            'players_count' => Yii::t('app', 'Players Count'),
            'amount' => Yii::t('app', 'Amount'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'status_id' => Yii::t('app', 'Status ID'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(LigsTypes::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(LigsStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGames()
    {
        return $this->hasMany(LigsGames::className(), ['lig_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsPlayers()
    {
        return $this->hasMany(LigsPlayers::className(), ['lig_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Users::className(), ['id' => 'player_id'])->viaTable('ligs_players', ['lig_id' => 'id']);
    }
}
