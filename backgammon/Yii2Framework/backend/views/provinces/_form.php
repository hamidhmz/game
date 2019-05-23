<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Provinces */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="provinces-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm']) ?>
    <?php ActiveForm::end(); ?>
</div>