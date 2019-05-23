<?php
/* @var $this yii\web\View */
/* @var $model common\models\Users */
$this->title = Yii::t('base', 'Users') . ' / ' . Yii::t('base', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('base', 'Create User');
?>
<div class="users-create">
    <?= $this->render('_form', [
        'model' => $model,
        'cities' => $cities,
        'provinces' => $provinces,
    ]) ?>
</div>