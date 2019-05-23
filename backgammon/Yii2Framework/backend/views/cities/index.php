<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('base', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-index">
    <p>
        <?= Html::a(Yii::t('base', 'Create Cities'), ['create'], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Search Panel'), null, ['class' => 'btn btn-sm', 'onclick' => "$('.cities-search').slideToggle();"]) ?>
    </p>
    <?= $this->render('_search', ['model' => $searchModel, 'provinces' => $provinces]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'province_id',
                'value' => function ($model) {
                    return $model->getProvince()->one()->title;
                },
            ],
            'title',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>
</div>