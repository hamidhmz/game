<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="users-form">
    <div style="background: rgba(0,0,0,0.2);padding: 15px;margin-bottom: 15px;">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <h4>اطلاعات کاربری</h4>
                <hr/>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'credit') ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <h4>اطلاعات شخصی</h4>
                <hr/>
                <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <h4>اطلاعات مکانی</h4>
                <hr/>
                <?= $form->field($model, 'province_id')->dropDownList(ArrayHelper::map($provinces, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
                <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map($cities, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')]) ?>
                <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
            </div>
        </div>
        <?= Html::submitButton(Yii::t('base', 'Submit'), ['class' => 'btn btn-sm']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
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
                $('#users-city_id').html(options);
            }
        });
    }
});
");
?>