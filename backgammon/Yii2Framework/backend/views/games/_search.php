<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\GamesSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="games-search" style="display: none;">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']) ?>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map($types, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'total_amount') ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'winner_id')->dropDownList(ArrayHelper::map($users, 'id', 'fullname'), ['prompt' => Yii::t('base', 'Select')]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'loser_id')->dropDownList(ArrayHelper::map($users, 'id', 'fullname'), ['prompt' => Yii::t('base', 'Select')]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-sm']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>