<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "games".
 *
 * @property integer $id
 * @property integer $player_1
 * @property integer $player_2
 * @property integer $type_id
 * @property integer $amount
 * @property integer $status_id
 * @property integer $total_amount
 * @property integer $winner_id
 * @property integer $loser_id
 * @property string $started_at
 * @property string $finished_at
 * @property string $datetime
 *
 * @property Users $player1
 * @property Users $player2
 * @property Users $winner
 * @property Users $loser
 * @property GamesStatus $status
 * @property GamesTypes $type
 * @property GamesBoards[] $gamesBoards
 */
class Games extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'games';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player_1', 'type_id', 'amount', 'status_id', 'total_amount', 'datetime'], 'required'],
            [['player_1', 'player_2', 'type_id', 'status_id', 'total_amount', 'winner_id', 'loser_id'], 'integer'],
            [['amount'], 'integer', 'max' => 2000000],
            [['started_at', 'finished_at', 'datetime'], 'safe'],
            [['player_1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['player_1' => 'id']],
            [['player_2'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['player_2' => 'id']],
            [['winner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['winner_id' => 'id']],
            [['loser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['loser_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => GamesStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GamesTypes::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'player_1' => Yii::t('app', 'Player 1'),
            'player_2' => Yii::t('app', 'Player 2'),
            'type_id' => Yii::t('app', 'Type ID'),
            'amount' => Yii::t('app', 'Amount'),
            'status_id' => Yii::t('app', 'Status ID'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'winner_id' => Yii::t('app', 'Winner ID'),
            'loser_id' => Yii::t('app', 'Loser ID'),
            'started_at' => Yii::t('app', 'Started At'),
            'finished_at' => Yii::t('app', 'Finished At'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer1()
    {
        return $this->hasOne(Users::className(), ['id' => 'player_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer2()
    {
        return $this->hasOne(Users::className(), ['id' => 'player_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWinner()
    {
        return $this->hasOne(Users::className(), ['id' => 'winner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoser()
    {
        return $this->hasOne(Users::className(), ['id' => 'loser_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(GamesStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(GamesTypes::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamesBoards()
    {
        return $this->hasMany(GamesBoards::className(), ['game_id' => 'id']);
    }
}
