<?php
/* @var $this yii\web\View */
/* @var $model common\models\Cities */
$this->title = Yii::t('base', 'Cities') . ' / ' . $model->title . ' / ' . Yii::t('base', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="cities-update">
    <?= $this->render('_form', [
        'model' => $model,
        'provinces' => $provinces,
    ]) ?>
</div>