<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_games_borads_status".
 *
 * @property integer $id
 * @property string $title
 *
 * @property LigsGamesBoards[] $ligsGamesBoards
 */
class LigsGamesBoradsStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_games_borads_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGamesBoards()
    {
        return $this->hasMany(LigsGamesBoards::className(), ['status_id' => 'id']);
    }
}
