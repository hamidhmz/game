<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_games_boards".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $winner_id
 * @property integer $status_id
 * @property string $started_at
 * @property string $finished_at
 *
 * @property LigsGames $game
 * @property Users $winner
 * @property LigsGamesBoradsStatus $status
 * @property LigsGamesBoardsDices[] $ligsGamesBoardsDices
 */
class LigsGamesBoards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_games_boards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'status_id', 'started_at', 'finished_at'], 'required'],
            [['game_id', 'winner_id', 'status_id'], 'integer'],
            [['started_at', 'finished_at'], 'safe'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsGames::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['winner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['winner_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsGamesBoradsStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'game_id' => Yii::t('app', 'Game ID'),
            'winner_id' => Yii::t('app', 'Winner ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'started_at' => Yii::t('app', 'Started At'),
            'finished_at' => Yii::t('app', 'Finished At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(LigsGames::className(), ['id' => 'game_id']);
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
    public function getStatus()
    {
        return $this->hasOne(LigsGamesBoradsStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGamesBoardsDices()
    {
        return $this->hasMany(LigsGamesBoardsDices::className(), ['board_id' => 'id']);
    }
}
