<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\config\components\functions;
/* @var $this yii\web\View */
/* @var $model common\models\Ligs */
$this->title = Yii::t('app', 'Ligs') . ' / ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ligs'), 'url' => ['index' . $model->status_id]];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="ligs-view">
    <?php
    if ($model->status_id == 1 && $playersCount == 0) {
        ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Ligs'), ['create'], ['class' => 'btn btn-sm']) ?>
            <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
            <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm', 'data' => ['confirm' => Yii::t('base', 'Are you sure you want to delete this item?'), 'method' => 'post']]) ?>
        </p>
        <?php
    }
    ?>
    <div class="table-responsive">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title',
                    [
                    'attribute' => 'type_id',
                    'value' => function ($model) {
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
                'start_time',
                    [
                    'label' => 'بازیکنان شرکت کرده',
                    'value' => function ($model) {
                        /* @var $model \common\models\Ligs */
                        return $model->getLigsPlayers()->count();
                    }
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
                    'attribute' => 'status_id',
                    'value' => function ($model) {
                        return $model->getStatus()->one()->title;
                    }
                ],
            ],
        ]);
        ?>
    </div>
    <div class="table-responsive">
        <br/>
        <table class="table text-center">
            <tbody>
                <?php
                $ligsGames = $model->getLigsGames()->orderBy(['id' => SORT_DESC])->all();
                echo '<tr>';
                $i = 0;
                $r = 2;
                $arr = functions::a($model->players_count);
                foreach ($ligsGames as $ligsGame) {
                    $colspan = 1;
                    echo '<td colspan="' . ($model->players_count / $r) . '" style="width: ' . ((100 / ($model->players_count / 2)) * $colspan) . '%;">';
                    echo '<p>';
                    echo ($ligsGame->player1 ? $ligsGame->player1->fullname : '---');
                    echo ' vs ';
                    echo ($ligsGame->player2 ? $ligsGame->player2->fullname : '---');
                    echo '</p>';
                    echo '<p>' . $ligsGame->status->title . '</p>';
                    if ($ligsGame->status_id == 3) {
                        echo '<p>برنده: ' . ($ligsGame->winner ? $ligsGame->winner->fullname : '---') . '</p>';
                    }
                    echo '</td>';
                    if (array_search($i, $arr)) {
                        echo '</tr><tr>';
                        $r = $r * 2;
                    }
                    $i++;
                }
                echo '</tr>';
                ?>
            </tbody>
        </table>
    </div>
</div>