<?php
namespace common\models;
use Yii;
/**
 * This is the model class for table "provinces".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Cities[] $cities
 * @property Users[] $users
 */
class Provinces extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'provinces';
    }
    public function rules() {
        return [
                [['title'], 'required'],
                [['title'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('base', 'ID'),
            'title' => Yii::t('base', 'Title'),
        ];
    }
    public function getCities() {
        return $this->hasMany(Cities::className(), ['province_id' => 'id']);
    }
    public function getUsers() {
        return $this->hasMany(Users::className(), ['province_id' => 'id']);
    }
}