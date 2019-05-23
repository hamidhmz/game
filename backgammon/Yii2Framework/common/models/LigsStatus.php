<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_status".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Ligs[] $ligs
 */
class LigsStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_status';
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
    public function getLigs()
    {
        return $this->hasMany(Ligs::className(), ['status_id' => 'id']);
    }
}
