<?php
use yii\widgets\DetailView;
use common\config\components\functions;
/* @var $this yii\web\View */
/* @var $model common\models\Games */
$this->title = Yii::t('base', 'Games Finsih') . ' / ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games Finsih'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="games-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'winner_id',
                'value' => $model->winner->fullname
            ],
            [
                'attribute' => 'loser_id',
                'value' => $model->loser->fullname
            ],
            [
                'attribute' => 'type_id',
                'value' => $model->type->title
            ],
            [
                'attribute' => 'total_amount',
                'value' => number_format($model->total_amount) . ' ' . Yii::t('base', 'Toman')
            ],
            [
                'attribute' => 'started_at',
                'contentOptions' => ['style' => 'direction: ltr;text-align:right;'],
                'value' => functions::convertdatetime($model->started_at)
            ],
            [
                'attribute' => 'finished_at',
                'contentOptions' => ['style' => 'direction: ltr;text-align:right;'],
                'value' => functions::convertdatetime($model->finished_at)
            ],
        ],
    ]) ?>
</div>