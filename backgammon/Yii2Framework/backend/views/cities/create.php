<?php
/* @var $this yii\web\View */
/* @var $model common\models\Cities */
$this->title = Yii::t('app', 'Cities') .' / '.Yii::t('app', 'Create Cities');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create Cities');
?>
<div class="cities-create">
    <?= $this->render('_form', [
        'model' => $model,
        'provinces' => $provinces,
    ]) ?>
</div>