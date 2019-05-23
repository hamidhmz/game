<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ligs */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("
//$('.datepicker').persianDatepicker({format: 'YYYY/MM/DD'});
");
?>

<div class="ligs-form">
    <div style="background: rgba(0,0,0,0.2);padding: 15px;margin-bottom: 15px;">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'title')->textInput() ?>
                <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map($ligs_type, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
                <?= $form->field($model, 'start_date')->textInput(['class' => 'datepicker form-control text-center']) ?>
                <?= $form->field($model, 'start_time')->textInput(['class' => 'datepicker form-control text-center']) ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'players_count')->dropDownList(Yii::$app->params['ligs.playersCount'], ['prompt' => Yii::t('base', 'Select')]) ?>
                <?= $form->field($model, 'amount')->textInput() ?>
                <?= $form->field($model, 'total_amount')->textInput() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
