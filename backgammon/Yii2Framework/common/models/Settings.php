<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $email_server
 * @property string $email_port
 * @property string $email_username
 * @property string $email_password
 * @property integer $send_email_after_register
 * @property string $email_text_after_register
 * @property string $site_title
 * @property string $site_copy_right
 * @property string $site_logo
 * @property string $site_favicon
 * @property integer $active_mellat_bank
 * @property integer $active_zarinpall
 * @property integer $default_gateway
 * @property string $mellat_code
 * @property string $mellat_username
 * @property string $mellat_password
 * @property string $zarinpal_merchant_id
 * @property integer $game_percent
 * @property integer $game_timeout
 * @property integer $game_disconnect
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_server', 'email_port', 'email_username', 'email_password', 'send_email_after_register', 'email_text_after_register', 'site_title', 'site_copy_right', 'site_logo', 'site_favicon', 'active_mellat_bank', 'active_zarinpall', 'default_gateway', 'mellat_code', 'mellat_username', 'mellat_password', 'zarinpal_merchant_id', 'game_percent', 'game_timeout', 'game_disconnect'], 'required'],
            [['send_email_after_register', 'active_mellat_bank', 'active_zarinpall', 'default_gateway', 'game_percent', 'game_timeout', 'game_disconnect'], 'integer'],
            [['email_text_after_register', 'site_copy_right'], 'string'],
            [['email_server', 'email_port', 'email_username', 'email_password', 'site_title', 'site_logo', 'site_favicon', 'mellat_code', 'mellat_username', 'mellat_password', 'zarinpal_merchant_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'email_server' => Yii::t('base', 'Email Server'),
            'email_port' => Yii::t('base', 'Email Port'),
            'email_username' => Yii::t('base', 'Email Username'),
            'email_password' => Yii::t('base', 'Email Password'),
            'send_email_after_register' => Yii::t('base', 'Send Email After Register'),
            'email_text_after_register' => Yii::t('base', 'Email Text After Register'),
            'site_title' => Yii::t('base', 'Site Title'),
            'site_copy_right' => Yii::t('base', 'Site Copy Right'),
            'site_logo' => Yii::t('base', 'Site Logo'),
            'site_favicon' => Yii::t('base', 'Site Favicon'),
            'active_mellat_bank' => Yii::t('base', 'Active Mellat Bank'),
            'active_zarinpall' => Yii::t('base', 'Active Zarinpall'),
            'default_gateway' => Yii::t('base', 'Default Gateway'),
            'mellat_code' => Yii::t('base', 'Mellat Code'),
            'mellat_username' => Yii::t('base', 'Mellat Username'),
            'mellat_password' => Yii::t('base', 'Mellat Password'),
            'zarinpal_merchant_id' => Yii::t('base', 'Zarinpal Merchant ID'),
            'game_percent' => Yii::t('base', 'Game Percent'),
            'game_timeout' => Yii::t('base', 'Game Timeout'),
            'game_disconnect' => Yii::t('base', 'Game Disconnect'),
        ];
    }
}
