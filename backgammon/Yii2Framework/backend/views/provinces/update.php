<?php
/* @var $this yii\web\View */
/* @var $model common\models\Provinces */
$this->title =  Yii::t('base', 'Provinces') .' / '. $model->title .' / '. Yii::t('base', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Provinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] =  Yii::t('base', 'Update');
?>
<div class="provinces-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>