<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_players".
 *
 * @property integer $id
 * @property integer $lig_id
 * @property integer $player_id
 * @property string $datetime
 *
 * @property Ligs $lig
 * @property Users $player
 */
class LigsPlayers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_players';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lig_id', 'player_id', 'datetime'], 'required'],
            [['lig_id', 'player_id'], 'integer'],
            [['datetime'], 'safe'],
            [['lig_id', 'player_id'], 'unique', 'targetAttribute' => ['lig_id', 'player_id'], 'message' => 'The combination of Lig ID and Player ID has already been taken.'],
            [['lig_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ligs::className(), 'targetAttribute' => ['lig_id' => 'id']],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['player_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lig_id' => Yii::t('app', 'Lig ID'),
            'player_id' => Yii::t('app', 'Player ID'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLig()
    {
        return $this->hasOne(Ligs::className(), ['id' => 'lig_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Users::className(), ['id' => 'player_id']);
    }
}
