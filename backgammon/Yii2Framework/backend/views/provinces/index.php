<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProvincesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('base', 'Provinces');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provinces-index">
    <p>
        <?= Html::a(Yii::t('base', 'Create Provinces'), ['create'], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Search Panel'), null, ['class' => 'btn btn-sm', 'onclick' => "$('.provinces-search').slideToggle();"]) ?>
    </p>
    <?= $this->render('_search', ['model' => $searchModel]);  ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>
</div>