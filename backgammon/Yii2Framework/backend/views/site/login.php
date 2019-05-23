<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
farsidesign\sbadminrtl\web\FontsAsset::register($this);
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback', 'autofocus' => 'autofocus'],
    'inputTemplate' => "{input}<i class='glyphicon glyphicon-user form-control-feedback'></i>",
];
$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<i class='glyphicon glyphicon-lock form-control-feedback'></i>",
];
$this->title = Yii::t('base', 'Login');
?>
<div class="site-login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div style="margin-top: 50px;background: rgba(0,0,0,0.4);padding: 15px;color: #FFF;">
                    <h3 style="margin: 0 0 15px 0;padding: 0;"><?= $settings->site_title ?></h3>
                    <hr/>
                    <?= Alert::widget() ?>
                    <?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
                    <?= $form->field($model, 'username', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
                    <?= $form->field($model, 'password', $fieldOptions2)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                    <label><?= $form->field($model, 'rememberMe')->checkbox() ?></label>
                    <?= Html::submitButton(Yii::t('base', 'Login'), ['class' => 'btn btn-lg btn-block']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>