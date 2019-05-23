<?php
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $form \yii\widgets\ActiveForm */
?>
<div style="background: rgba(0,0,0,0.2);margin: -10px -12.5px -10px -10px;padding: 10px;">
    <fieldset style="margin-bottom: 20px;">
        <legend style="color: #FFF;border-bottom-color: rgba(255, 255, 255, 0.2);padding-bottom: 10px;"><i class="fa fa-envelope"></i> تنظیمات ارسال ایمیل</legend>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'email_server')->textInput(['maxlength' => true, 'dir' => 'ltr'])->label('سرویس دهنده ایمیل')->hint('مثال : smtp.gmail.com') ?>
                <?= $form->field($model, 'email_port')->textInput(['maxlength' => true, 'dir' => 'ltr'])->label('درگاه ارسال ایمیل (port)')->hint('مثال : 587') ?>
                <?= $form->field($model, 'email_username')->textInput(['maxlength' => true, 'dir' => 'ltr'])->label('نام کاربری سرویس ایمیل') ?>
                <?= $form->field($model, 'email_password')->textInput(['maxlength' => true, 'dir' => 'ltr'])->label('رمز عبور سرویس ایمیل') ?>
                <?= $form->field($model, 'send_email_after_register')->radioList([1 => 'بله', 0 => 'خیر'])->label('پس از اتمام ثبت نام کاربر، به کاربر ایمیل ارسال شود؟') ?>
                <?= $form->field($model, 'email_text_after_register')->widget(CKEditor::className(), [
                    'options' => [
                        'rows' => 6
                    ],
                    'clientOptions' => [
                        'language' => 'fa',
                        'extraPlugins' => 'bidi',
                        'toolbarGroups' => [
                                ['name' => 'bidi']
                        ]
                    ],
                    'preset' => 'basic',
                ])->label('متن ایمیل پس از ثبت نام کاربر') ?>
            </div>
        </div>
    </fieldset>
</div>