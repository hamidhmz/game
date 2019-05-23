<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\CitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="cities-search" style="display: none;">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'province_id')->dropDownList(ArrayHelper::map($provinces, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'title') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>