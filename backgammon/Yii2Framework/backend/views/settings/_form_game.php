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
                <?= $form->field($model, 'game_timeout')->textInput(['dir' => 'ltr'])->label('زمان بازی')->hint('ms میلی ثانیه، هر 1 ثانیه برابر 1000ms') ?>
                <?= $form->field($model, 'game_disconnect')->textInput(['dir' => 'ltr'])->label('زمان آفلاین')->hint('ms میلی ثانیه، هر 1 ثانیه برابر 1000ms') ?>
            </div>
        </div>
    </fieldset>
</div>