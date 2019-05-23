<?php
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\models\ChangePassword */
$this->title = 'تغییر رمز عبور';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-change-password">
    <div class="row">
        <div class="col xl4 l4 m3 s12"></div>
        <div class="col xl4 l4 m6 s12">
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'old_password')->passwordInput() ?>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                <?= $form->field($model, 'new_password_repeat')->passwordInput() ?>
                <br/>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn waves-effect']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>