<?php
/* @var $form \yii\widgets\ActiveForm */
?>
<div style="background: rgba(0,0,0,0.2);margin: -10px -12.5px -10px -10px;padding: 10px;">
   
    <fieldset style="margin: 30px 0 20px;">
        <legend style="color: #FFF;border-bottom-color: rgba(255, 255, 255, 0.2);padding-bottom: 10px;">درگاه های پرداخت فعال</legend>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'active_zarinpall')->radiolist([1 => 'بلی', 0 => 'خیر'])->label('فعال سازی پرداخت با استفاده از درگاه پرداخت زرین پال ؟') ?>
                <?= $form->field($model, 'default_gateway')->radiolist([1 => 'درگاه پرداخت زرین پال'])->label('نحوه پرداخت پیشفرض ؟') ?>
            </div>
        </div>
    </fieldset>
   
    <fieldset style="margin: 30px 0 20px;">
        <legend style="color: #FFF;border-bottom-color: rgba(255, 255, 255, 0.2);padding-bottom: 10px;">تنظیمات درگاه پرداخت زرین پال</legend>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'zarinpal_merchant_id')->textInput(['dir' => 'ltr'])->label('MERCHANT ID درگاه پرداخت زرین پال') ?>
            </div>
        </div>
    </fieldset>
</div>