<?php
use yii\helpers\Url;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $model \frontend\models\SignupForm */
$this->title = 'ثبت نام';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup" style="padding-top: 50px;">
    <div class="row">
        <div class="col xl4 l4 m3 s12"></div>
        <div class="col xl4 l4 m6 s12">
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <?php $form_signup = ActiveForm::begin(); ?>
                <?= $form_signup->field($model_signup, 'fullname') ?>
                <?= $form_signup->field($model_signup, 'email') ?>
                <?= $form_signup->field($model_signup, 'username') ?>
                <?= $form_signup->field($model_signup, 'password')->passwordInput(['maxlength' => true]) ?>
                <br/>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('base', 'Signup'), ['class' => 'btn waves-effect']) ?>
                </div>
                <br/>
                <a class="right" href="<?= Url::to(['/site/login']) ?>"><?= Yii::t('base', 'Login') ?></a>
                <a class="left" href="<?= Url::to(['/site/request-password-reset']) ?>"><?= Yii::t('base', 'Request Password Reset') ?></a>
                <div class="clearfix"></div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>