<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_games_boards_dices".
 *
 * @property integer $id
 * @property integer $board_id
 * @property integer $player_id
 * @property integer $roll_1
 * @property integer $roll_2
 * @property string $datetime
 *
 * @property LigsGamesBoards $board
 * @property Users $player
 * @property LigsGamesBoardsPlays[] $ligsGamesBoardsPlays
 */
class LigsGamesBoardsDices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_games_boards_dices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['board_id', 'player_id', 'roll_1', 'roll_2', 'datetime'], 'required'],
            [['board_id', 'player_id', 'roll_1', 'roll_2'], 'integer'],
            [['datetime'], 'safe'],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsGamesBoards::className(), 'targetAttribute' => ['board_id' => 'id']],
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
            'board_id' => Yii::t('app', 'Board ID'),
            'player_id' => Yii::t('app', 'Player ID'),
            'roll_1' => Yii::t('app', 'Roll 1'),
            'roll_2' => Yii::t('app', 'Roll 2'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(LigsGamesBoards::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Users::className(), ['id' => 'player_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGamesBoardsPlays()
    {
        return $this->hasMany(LigsGamesBoardsPlays::className(), ['dice_id' => 'id']);
    }
}
