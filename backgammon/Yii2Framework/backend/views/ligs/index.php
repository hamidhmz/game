<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\config\components\functions;
/* @var $this yii\web\View */
/* @var $searchModel common\models\LigsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Ligs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ligs-index">
    <?php
    if (Yii::$app->controller->action->id == 'index1') {
        ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Ligs'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
            <?= Html::a(Yii::t('base', 'Search Panel'), null, ['class' => 'btn btn-sm', 'onclick' => "$('.ligs-search').slideToggle();"]) ?>
        </p>
        <?= $this->render('_search', ['model' => $searchModel]) ?>
        <?php
    }
    ?>
    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                    'attribute' => 'type_id',
                    'value' => function ($model) {
                        /* @var $model \common\models\Ligs */
                        return $model->type->title . ' / ' . $model->players_count . ' نفره';
                    }
                ],
                    [
                    'attribute' => 'start_date',
                    'value' => function ($model) {
                        /* @var $model \common\models\Ligs */
                        return functions::convertdate($model->start_date);
                    }
                ],
                    [
                    'attribute' => 'start_time',
                ],
                    [
                    'attribute' => 'amount',
                    'value' => function ($model) {
                        /* @var $model \common\models\Ligs */
                        return $model->amount ? number_format($model->amount) . ' ' . Yii::t('base', 'Toman') : $model->amount;
                    }
                ],
                    [
                    'attribute' => 'total_amount',
                    'value' => function ($model) {
                        /* @var $model \common\models\Ligs */
                        return $model->total_amount ? number_format($model->total_amount) . ' ' . Yii::t('base', 'Toman') : $model->total_amount;
                    }
                ],
                    [
                    'label' => 'بازیکنان شرکت کرده',
                    'value' => function ($model) {
                        /* @var $model \common\models\Ligs */
                        return $model->getLigsPlayers()->count() . ' نفر';
                    }
                ],
                    [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons' => [
                        'update' => function ($model) {
                            /* @var $model \common\models\Ligs */
                            $playersCount = $model->getLigsPlayers()->count();
                            return ($model->status_id == 1 && $playersCount == 0);
                        },
                        'delete' => function ($model) {
                            /* @var $model \common\models\Ligs */
                            $playersCount = $model->getLigsPlayers()->count();
                            return ($model->status_id == 1 && $playersCount == 0);
                        }
                    ]
                ],
            ],
        ])
        ?>
    </div>
</div>