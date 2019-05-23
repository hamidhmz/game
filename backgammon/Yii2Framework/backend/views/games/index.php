<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\config\components\functions;
/* @var $this yii\web\View */
/* @var $searchModel common\models\GamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('base', 'Games Finish');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="games-index">
    <p><?= Html::a(Yii::t('base', 'Search Panel'), null, ['class' => 'btn btn-sm', 'onclick' => "$('.games-search').slideToggle();"]) ?></p>
    <?= $this->render('_search', ['model' => $searchModel, 'users' => $users, 'types' => $types]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type_id',
                'value' => function ($model) {
                    return $model->getType()->one()->title;
                }
            ],
            [
                'attribute' => 'total_amount',
                'value' => function ($model) {
                    return number_format($model->total_amount) . ' تومان';
                }
            ],
            [
                'attribute' => 'winner_id',
                'value' => function ($model) {
                    return $model->winner ? $model->winner->fullname : '';
                }
            ],
            [
                'attribute' => 'loser_id',
                'value' => function ($model) {
                    return $model->loser ? $model->loser->fullname : '';
                }
            ],
            [
                'attribute' => 'finished_at',
                'contentOptions' => ['style' => 'direction: ltr;text-align: right;'],
                'value' => function ($model) {
                    return $model->finished_at ? functions::convertdatetime($model->finished_at) : '';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]) ?>
</div>