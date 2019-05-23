<?php
use yii\helpers\Url;
/* @var $form \yii\widgets\ActiveForm */
$this->registerJsFile(Url::to(['/assets/backend/js/preview.js']));
?>
<div style="background: rgba(0,0,0,0.2);margin: -10px -12.5px -10px -10px;padding: 10px;">
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'site_title')->textInput(['maxlength' => true])->label('عنوان سایت') ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'site_copy_right')->label('متن کپی رایت')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="pull-right">
                <?= $form->field($model, 'site_logo')->label('لوگو')->fileInput(['onchange' => "preview(this, 'site_logo');"]) ?>
            </div>
            <div class="pull-left" id="site_logo" style="width: 100px;height: 100px;">
                <a target="_blank" href="<?= Url::to(['../uploads/settings/logo/' . $model->site_logo]) ?>">
                    <img src="<?= Url::to(['../uploads/settings/logo/' . $model->site_logo]) ?>" style="max-width: 100%;"/>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="pull-right">
                <?= $form->field($model, 'site_favicon')->label('فاویکون')->fileInput(['onchange' => "preview(this, 'site_favicon');"]) ?>
            </div>
            <div class="pull-left" id="site_favicon" style="width: 100px;height: 100px;">
                <a target="_blank" href="<?= Url::to(['../uploads/settings/favicon/' . $model->site_favicon]) ?>">
                    <img src="<?= Url::to(['../uploads/settings/favicon/' . $model->site_favicon]) ?>" style="max-width: 100%;"/>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>