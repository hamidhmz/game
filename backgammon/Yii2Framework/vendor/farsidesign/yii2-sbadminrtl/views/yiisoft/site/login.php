<?php
/**
 * login.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
farsidesign\sbadminrtl\web\FontsAsset::register($this);

$this->title = Yii::t('sbadmin','Login');

$fieldOptions1 = [
	'options' => ['class' => 'form-group has-feedback', 'autofocus' => 'autofocus'],
	'inputTemplate' => "{input}<i class='glyphicon glyphicon-envelope form-control-feedback'></i>",
];

$fieldOptions2 = [
	'options' => ['class' => 'form-group has-feedback'],
	'inputTemplate' => "{input}<i class='glyphicon glyphicon-lock form-control-feedback'></i>",
];
?>
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=Yii::t('sbadmin','Please Sign In')?></h3>
                    </div>
                    <div class="panel-body">
                    <?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'enableClientValidation' => false
			]); ?>

				<?= $form
					->field($model,'username', $fieldOptions1)
					->label(false)
					->textInput(['placeholder' => $model->getAttributeLabel('username')])
				?>

				<?= $form
					->field($model,'password', $fieldOptions2)
					->label(false)
					->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
				?>

				<div class="checkbox">
                <label>
						<?= $form->field($model,'rememberMe')->checkbox() ?>
                        </label>
                </div>        
						<?= Html::submitButton(Yii::t('sbadmin','Login'), [
							'class' => 'btn btn-lg btn-success btn-block',
							'name' => 'login-button'
						]) ?>
				

			<?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
</div>
