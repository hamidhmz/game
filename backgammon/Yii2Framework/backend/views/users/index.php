<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('base', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a(Yii::t('base', 'Create User'), ['create'], ['class' => 'btn btn-sm']) ?>
        <?= Html::a(Yii::t('base', 'Search Panel'), null, ['class' => 'btn btn-sm', 'onclick' => "$('.users-search').slideToggle();"]) ?>
    </p>
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                'fullname',
                'email:email',
                [
                    'attribute' => 'credit',
                    'value' => function($model) {
                        /* @var $model common\models\Users */
                        return $model->credit ? number_format($model->credit) . ' ' . Yii::t('base', 'Toman') : $model->credit;
                    },
                ],
                [
                    'attribute' => 'status_id',
                    'value' => function($model) {
                        /* @var $model common\models\Users */
                        if ($model->status_id == Yii::$app->params['users.statusActive']) {
                            return Yii::t('base', 'Active');
                        }
                        else if ($model->status_id == Yii::$app->params['users.statusInActive']) {
                            return Yii::t('base', 'DeActive');
                        }
                        return '???';
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]) ?>
    </div>
</div>