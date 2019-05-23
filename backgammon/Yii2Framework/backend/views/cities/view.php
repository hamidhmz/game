<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\Cities */
$this->title = Yii::t('base', 'Cities') . ' / ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="cities-view">
    <p>       
        <?= Html::a(Yii::t('base', 'Create Cities'), ['create', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['confirm' => Yii::t('base', 'Are you sure you want to delete this item?'), 'method' => 'post']]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'province_id',
                'value' => function ($model) {
                    /* @var $model \common\models\Cities */
                    return $model->province->title;
                },
            ],
            'title',
        ],
    ]) ?>
</div>