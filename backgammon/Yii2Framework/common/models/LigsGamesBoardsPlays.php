<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_games_boards_plays".
 *
 * @property integer $id
 * @property integer $dice_id
 * @property integer $from
 * @property integer $to
 * @property string $datetime
 *
 * @property LigsGamesBoardsDices $dice
 */
class LigsGamesBoardsPlays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_games_boards_plays';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dice_id', 'from', 'to', 'datetime'], 'required'],
            [['dice_id', 'from', 'to'], 'integer'],
            [['datetime'], 'safe'],
            [['dice_id'], 'exist', 'skipOnError' => true, 'targetClass' => LigsGamesBoardsDices::className(), 'targetAttribute' => ['dice_id' => 'id']],
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
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDice()
    {
        return $this->hasOne(LigsGamesBoardsDices::className(), ['id' => 'dice_id']);
    }
}
