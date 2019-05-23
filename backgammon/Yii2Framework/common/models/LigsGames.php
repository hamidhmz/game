<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_games".
 *
 * @property integer $id
 * @property integer $lig_id
 * @property integer $status_id
 * @property integer $player_1
 * @property integer $player_2
 * @property integer $winner_id
 * @property integer $loser_id
 * @property string $started_at
 * @property string $finished_at
 *
 * @property Users $player1
 * @property Users $player2
 * @property LigsGamesStatus $status
 * @property Users $winner
 * @property Users $loser
 * @property Ligs $lig
 * @property LigsGamesBoards[] $ligsGamesBoards
 */
class LigsGames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_games';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lig_id', 'status_id'], 'required'],
            [['lig_id', 'status_id', 'player_1', 'player_2', 'winner_id', 'loser_id'], 'integer'],
            [['started_at', 'finished_at'], 'safe'],
            [['player_1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['player_1' => 'id']],
            [['player_2'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['player_2' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsGamesStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['winner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['winner_id' => 'id']],
            [['loser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['loser_id' => 'id']],
            [['lig_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ligs::className(), 'targetAttribute' => ['lig_id' => 'id']],
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
            'status_id' => Yii::t('app', 'Status ID'),
            'player_1' => Yii::t('app', 'Player 1'),
            'player_2' => Yii::t('app', 'Player 2'),
            'winner_id' => Yii::t('app', 'Winner ID'),
            'loser_id' => Yii::t('app', 'Loser ID'),
            'started_at' => Yii::t('app', 'Started At'),
            'finished_at' => Yii::t('app', 'Finished At'),
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
    public function getStatus()
    {
        return $this->hasOne(LigsGamesStatus::className(), ['id' => 'status_id']);
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
    public function getLig()
    {
        return $this->hasOne(Ligs::className(), ['id' => 'lig_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGamesBoards()
    {
        return $this->hasMany(LigsGamesBoards::className(), ['game_id' => 'id']);
    }
}
