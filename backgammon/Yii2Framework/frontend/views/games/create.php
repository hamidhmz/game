<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $user \common\models\Users */
/* @var $model \common\models\Games */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
$this->title = 'شروع بازی';
?>
<style type="text/css">
    .select-dropdown ,.caret {visibility: hidden;position: absolute;}

    #games-type_id {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
</style>
<div class="games-create text-white">
     <div class="row">
        <div class="col-sm-12" style="margin: 30px 0;">
            
            <a class="btn btn-warning" href="<?= Url::to(['/games/index']) ?>">بازگشت به میزهای بازی</a>
            
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-white" style="margin: 50px 0; font-size: 16px">
            کاربر گرامی برای ایجاد میز بازی مبلغ پیشنهادی را وارد و نوع بازی را انتخاب کنید :
        </div>
        <div class="col-sm-6 pull-right">
            <div class="grey darken-3 text-black" style="padding: 15px;direction: rtl;min-height: 290px;">
                <?php $form = ActiveForm::begin(); ?>
                <div>
                    <label class="text-white">مبلغ مورد نظر خود را وارد کنید :</label>
                    <input id="games-amount" class="form-control" placeholder="مبلغ مورد نظر خود را وارد کنید " name="Games[amount]" type="text">
                </div>
                <div style="margin: 20px 0">
                    <label class="text-white">نوع بازی را انتخاب کنید :</label>
                    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map($games_type, 'id', 'title'), ['prompt' => Yii::t('base', 'Select')])->label(false) ?>
                </div>
                <br/>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('base', 'Submit1'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div id="connecting">در حال اتصال به سرور ...</div>
</div>
<script>
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
    var play_url = '<?= Url::to(['play']) ?>/';
    var profile_url = '<?= Url::to(['/profile']) ?>/';
</script>
<?php
$depends = ['depends' => 'frontend\assets\AppAsset'];
$this->registerCssFile('@web/themes/sixpairs/css/games_create.css', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/socket.io.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/node_config.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/games_create.js', $depends);
?>