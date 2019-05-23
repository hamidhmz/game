<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_games_status".
 *
 * @property integer $id
 * @property string $title
 *
 * @property LigsGames[] $ligsGames
 */
class LigsGamesStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_games_status';
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
    public function getLigsGames()
    {
        return $this->hasMany(LigsGames::className(), ['status_id' => 'id']);
    }
}
