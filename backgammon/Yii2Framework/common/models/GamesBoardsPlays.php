<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "games_boards_plays".
 *
 * @property integer $id
 * @property integer $dice_id
 * @property integer $from
 * @property integer $to
 * @property integer $distance
 * @property string $datetime
 *
 * @property GamesBoardsDices $dice
 */
class GamesBoardsPlays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'games_boards_plays';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dice_id', 'from', 'to', 'distance', 'datetime'], 'required'],
            [['dice_id', 'from', 'to', 'distance'], 'integer'],
            [['datetime'], 'safe'],
            [['dice_id'], 'exist', 'skipOnError' => true, 'targetClass' => GamesBoardsDices::className(), 'targetAttribute' => ['dice_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dice_id' => Yii::t('app', 'Dice ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'distance' => Yii::t('app', 'Distance'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDice()
    {
        return $this->hasOne(GamesBoardsDices::className(), ['id' => 'dice_id']);
    }
}
