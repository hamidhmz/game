<?php
use yii\helpers\Url;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
$this->title = 'بازیابی رمز عبور';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset" style="padding-top: 50px;">
    <div class="row">
        <div class="col xl4 l4 m3 s12"></div>
        <div class="col xl4 l4 m6 s12">
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <!--<p>آدرس ایمیل خود را وارد کنید</p>-->
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'email')->textInput(['dir' => 'ltr', 'style' => 'text-align: left;']) ?>
                <br/>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('base', 'Send'), ['class' => 'btn waves-effect']) ?>
                </div>
                <br/>
                <a class="right" href="<?= Url::to(['/site/login']) ?>"><?= Yii::t('base', 'Login') ?></a>
                <a class="left" href="<?= Url::to(['/site/signup']) ?>"><?= Yii::t('base', 'Signup') ?></a>
                <div class="clearfix"></div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
