<?php
/* @var $this yii\web\View */
/* @var $model common\models\Users */
$this->title = Yii::t('base', 'Users') . ' / ' . $model->fullname . ' / ' . Yii::t('base', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="users-update">
    <?= $this->render('_form', [
        'model' => $model,
        'cities' => $cities,
        'provinces' => $provinces,
    ]) ?>
</div>