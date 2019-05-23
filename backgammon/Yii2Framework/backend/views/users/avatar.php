<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
/* @var $form yii\widgets\ActiveForm */
Modal::begin(['id' => 'avatar_modal', 'header' => 'تغییر تصویر آواتار']);
$form = ActiveForm::begin(['id' => 'avatar_form', 'action' => Url::to(['change-avatar']), 'options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="row">
    <div class="col-xs-8">
        <input name="user_id" id="avatar_user_id" type="hidden" value=""/>
        <input name="user_avatar" type="file"/>
    </div>
    <div class="col-xs-4">
        <input type="submit" value="ثبت" class="btn btn-sm"/>
    </div>
</div>
<?php
ActiveForm::end();
Modal::end();