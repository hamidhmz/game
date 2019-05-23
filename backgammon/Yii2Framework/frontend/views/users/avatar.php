<?php
use yii\helpers\Url;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\Users */
$this->title = 'تغییر عکس آواتار';
$this->params['breadcrumbs'][] = ['label' => 'پروفایل', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::to(['/assets/frontend/js/preview2.js']));
?>
<div class="users-avatar">
    <div class="row">
        <div class="col xl4 l4 m3 s12"></div>
        <div class="col xl4 l4 m6 s12">
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'avatar')->fileInput(['onchange' => 'preview(this,\'preview_avatar\');'])->label(false) ?>
                <div id="preview_avatar" style="margin: 20px 0;text-align: center;width: 50%;margin: 0 auto;">
                    <img style="width: 100%;height: auto" src="<?= ($model->avatar && file_exists('uploads/users/avatar/' . $model->avatar)) ? Url::to(['uploads/users/avatar/' . $model->avatar]) : Url::to(['/uploads/users/avatar/default.png']) ?>"/>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn waves-effect']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>