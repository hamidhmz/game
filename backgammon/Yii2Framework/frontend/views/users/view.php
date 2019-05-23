<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\User */
if (!Yii::$app->user->isGuest && Yii::$app->user->id == $model->id) {
    $this->title = 'پروفایل';
}
else {
    $this->title = 'پروفایل ' . $model->fullname;
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
    <div class="row">
        <div class="col xl12 l12 m12 s12">
            <div style="margin-bottom: 15px;">
                <a class="btn waves-effect" href="<?= Url::to(['update']) ?>">تغییر مشخصات</a>
                <a class="btn waves-effect" href="<?= Url::to(['credit']) ?>">شارژ حساب</a>
                <a class="btn waves-effect" href="<?= Url::to(['avatar']) ?>">تغییر عکس آواتار</a>
                <a class="btn waves-effect" href="<?= Url::to(['change-password']) ?>">تغییر رمز عبور</a>
            </div>
            <div class="grey darken-3 white-text" style="padding: 15px;">
                <ul class="profile">
                    <li><span class="min_width">نام</span> <span><?= $model->fullname ?> </span></li>
                    <li><span class="min_width">نام کاربری</span> <span><?= $model->username ?> </span></li>
                    <li><span class="min_width">ایمیل</span> <span><?= $model->email ?> </span></li>
                    <li><span class="min_width">موجودی حساب</span> <span><?= number_format($model->credit) ?> تومان</span></li>
                    <li><span class="min_width">استان</span> <span><?= $model->province ? $model->province->title : '---' ?> </span></li>
                    <li><span class="min_width">شهر</span> <span><?= $model->city ? $model->city->title : '---' ?> </span></li>
                    <li><span class="min_width">آدرس</span> <span><?= $model->address ? $model->address : '---' ?> </span></li>
                    <li><span class="min_width">شماره تلفن ثابت</span> <span><?= $model->phone ? $model->phone : '---' ?> </span></li>
                    <li><span class="min_width">شماره تلفن همراه</span> <span><?= $model->mobile ? $model->mobile : '---' ?> </span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss("
    .btn {margin-bottom: 7px;}
    .min_width{float:right;min-width: 150px;font-weight: bold;}
    .profile {margin: 0;padding: 0;}
    .profile li:not(:last-child) {margin-bottom: 7px;padding-bottom: 8px;}
    
    @media (max-width: 772px) {
        .profile li:not(:last-child) {border-bottom: 1px solid #AAA;}
        .profile li span {display: block;width: 100%;}
        .profile li span:first-child {text-align: center !important;margin-bottom: 15px;}
        
    }

");
