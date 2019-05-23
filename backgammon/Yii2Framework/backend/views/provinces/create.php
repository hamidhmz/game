<?php
/* @var $this yii\web\View */
/* @var $model common\models\Provinces */
$this->title = Yii::t('base', 'Provinces') . ' / ' . Yii::t('base', 'Create Provinces');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Provinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('base', 'Create Provinces');
?>
<div class="provinces-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>