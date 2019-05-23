<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Cities */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="cities-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'province_id')->dropDownList(ArrayHelper::map($provinces, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
        </div>
    </div>
    <?= Html::submitButton(Yii::t('base', 'Submit'), ['class' => 'btn btn-sm']) ?>
    <?php ActiveForm::end(); ?>
</div>