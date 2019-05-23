<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ligs_types".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Ligs[] $ligs
 */
class LigsTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ligs_types';
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
        return $this->hasMany(Ligs::className(), ['type_id' => 'id']);
    }
}
