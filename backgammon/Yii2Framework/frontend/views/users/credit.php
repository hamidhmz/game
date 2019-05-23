<?php
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\User */

$this->title = ' افزایش اعتبار';
$this->params['breadcrumbs'][] = ['label' => 'پروفایل', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-credit">
    <div class="row">
        <div class="col xl4 l4 m3 s12"></div>
        <div class="col xl4 l4 m6 s12">
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <?php $form = ActiveForm::begin(); ?>
                <div>موجودی فعلی حساب شما: <?= number_format($last_credit) ?> تومان</div>
                <?= $form->field($model, 'credit') ?>
                <br/>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn waves-effect']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
