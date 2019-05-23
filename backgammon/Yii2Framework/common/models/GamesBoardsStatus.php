<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "games_boards_status".
 *
 * @property integer $id
 * @property string $title
 *
 * @property GamesBoards[] $gamesBoards
 */
class GamesBoardsStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'games_boards_status';
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
    public function getGamesBoards()
    {
        return $this->hasMany(GamesBoards::className(), ['status_id' => 'id']);
    }
}
