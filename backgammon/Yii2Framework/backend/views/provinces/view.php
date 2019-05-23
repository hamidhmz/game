<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\Provinces */
$this->title = Yii::t('base', 'Provinces') . ' / ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Provinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="provinces-view">
    <p>
        <?= Html::a(Yii::t('base', 'Create Provinces'), ['create', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['confirm' => Yii::t('base', 'Are you sure you want to delete this item?'), 'method' => 'post']]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'label' => Yii::t('app', 'Cities'),
                'value' => function ($model) {
                    return $model->getCities()->count();
                }
            ],
        ],
    ]) ?>
</div>