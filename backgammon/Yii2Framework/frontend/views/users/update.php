<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Users */
$this->title = 'تغییر مشخصات';
//$this->params['breadcrumbs'][] = ['label' => 'پروفایل', 'url' => ['view']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-update">
    <div class="row">
        <div class="col xl4 l4 m3 s12"></div>
        <div class="col xl4 l4 m6 s12">
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'province_id')->dropDownList(ArrayHelper::map($provinces, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
                <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map($cities, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
                <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn waves-effect']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss(".input-field label { left: auto; right: 0}");
$this->registerJs("
$('#users-province_id').change(function () {
    var province_id = $(this).val();
    $('#users-city_id').html('<option value=\"\">انتخاب کنید</option>');
    if (province_id) {
        $.ajax({
            url: '" . Url::to(['get-cities']) . "',
            dataType: 'json',
            data: {province_id: province_id},
            success: function (rows) {
                var options = '<option value=\"\">انتخاب کنید</option>';
                if (rows && rows.length) {
                    for (var index in rows) {
                        var row = rows[index];
                        options += '<option value=\"' + row.id + '\">' + row.title + '</option>';
                    }
                }
                $('#users-city_id').html(options).material_select();
            }
        });
    }
});
");
?>