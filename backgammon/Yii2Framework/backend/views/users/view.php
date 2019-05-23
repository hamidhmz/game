<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = Yii::t('base', 'Users') . ' / ' . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->fullname;
?>
<div class="user-view">
    <p>
        <?= Html::a(Yii::t('base', 'Create User'), ['create'], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['confirm' => Yii::t('base', 'Are you sure you want to delete this item?'), 'method' => 'post',],]) ?>
        <?= Html::a(Yii::t('base', 'Reset Password'), ['reset-password', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['method' => 'post']]) ?>
        <?= Html::a(Yii::t('base', 'Change Avatar'), null, ['class' => 'btn btn-sm change-avatar', 'data-id' => $model->id]) ?>
        <?php
        if ($model->status_id == Yii::$app->params['users.statusActive']) {
            echo Html::a(Yii::t('base', 'DeActive User'), ['de-active', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['method' => 'post']]) . " ";
        }
        ?>
        <?php
        if ($model->status_id == Yii::$app->params['users.statusInActive']) {
            echo Html::a(Yii::t('base', 'Active User'), ['active', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['method' => 'post']]) . " ";
        }
        ?>
    </p>

    <div style="background: rgba(0, 0, 0, 0.5);padding: 15px;">
        <div class="row">
            <div class="col-lg-3" dir="ltr">
                <a href="<?= Url::to([Yii::getAlias("@adminUserAvatarPath/$model->avatar")]) ?>" target="_blank">
                    <img src="<?= Url::to([Yii::getAlias("@adminUserAvatarPath/$model->avatar")]) ?>" style="width: 100%;height: auto;margin-bottom: 15px;"/>
                </a>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-5" style="margin-bottom: 15px;">
                        <div style="margin-bottom: 15px;"><span class="min-width">نام و نام خانوادگی</span>: <?= $model->fullname ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">شماره تلفن ثابت</span>: <?= $model->phone ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">شماره تلفن همراه</span>: <?= $model->mobile ?></div>
                    </div>
                    <div class="col-lg-7" style="margin-bottom: 15px;">
                        <div style="margin-bottom: 15px;"><span class="min-width">نام کاربری</span>: <?= $model->username ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">ایمیل</span>: <?= $model->email ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">اعتبار</span>: <?= $model->credit ? number_format($model->credit) . ' ' . Yii::t('base', 'Toman') : $model->credit ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">وضعیت</span>: <?= $model->status->title ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-bottom: 15px;"><span class="min-width">استان</span>: <?= $model->province ? $model->province->title : '' ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">شهر</span>: <?= $model->city ? $model->city->title : '' ?></div>
                        <div style="margin-bottom: 15px;"><span class="min-width">آدرس</span>: <?= $model->address ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss("
    .min-width{display: inline-block;min-width: 110px;font-weight: bold;}
    .modal-content{
        background-image: url(" . Url::to(['/themes/classic/images/lights.jpg']) . ");
        background-size: cover;
    }
");
$this->registerJs("
    $('.change-avatar').click(function(e) {
   e.preventDefault();
   var user_id = $(this).attr('data-id');
   $('#avatar_modal').modal('show').find('#avatar_user_id').val(user_id);
});
");
?>
<?= $this->render('avatar') ?>

