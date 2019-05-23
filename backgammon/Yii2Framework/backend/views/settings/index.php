<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'تنظیمات سایت');
$this->params['breadcrumbs'][] = Yii::t('app', 'تنظیمات سایت');
?>
<div class="settings-form">
    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
    <?= TabsX::widget([
        'items' => [
            [
                'label' => 'مشخصات فردی سایت',
                'content' => $this->render('_form_personality', [
                    'form' => $form,
                    'model' => $model,
                ]),
                'active' => true
            ],
            [
                'label' => 'تنظیمات ایمیل',
                'content' => $this->render('_form_email', [
                    'form' => $form,
                    'model' => $model,
                ]),
            ],
            [
                'label' => 'تنظیمات پرداخت و پلان های ویژه ',
                'content' => $this->render('_form_payment', [
                    'form' => $form,
                    'model' => $model,
                ]),
            ],
            [
                'label' => 'تنظیمات بازی',
                'content' => $this->render('_form_game', [
                    'form' => $form,
                    'model' => $model,
                ]),
            ],
        ],
    ]) ?>
    <div style="background: rgba(0,0,0,0.2);margin: 0 -2.5px 0 0;padding: 15px;">
        <?= Html::submitButton(Yii::t('base', 'Submit'), ['class' => 'btn btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>