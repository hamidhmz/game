<?php
use yii\helpers\Url;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use common\config\components\functions;
/* @var $this \yii\web\View */
/* @var $user \common\models\Users */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'History');
?>
<div class="games-index">

    <div class="row">
        <div class="col-sm-12" style="margin: 30px 0;">
            
             <a class="btn btn-success" href="<?= Url::to(['/games/create']) ?>">ساخت بازی جدید</a>
            <a class="btn btn-warning" href="<?= Url::to(['/games/index']) ?>">بازگشت به میزهای بازی</a>
            
        </div>
    </div>
<hr>
    <div class="row">
        <div class="col-sm-12" style="margin: 30px 0;">        
            <p class="text-white">کاربر گرامی رنگهای سبز بازی های برده ی شما هستند و رنگ های قرمز بازی هایی که باخته اید .</p>
        </div>
    </div>
    <hr>
    <div class="row" style="margin-top: 30px;">
        <div class="col-xs12">
            <div class=" darken-3 text-white" style="padding: 15px;direction: rtl;min-height: 290px;">
                <?=
                GridView::widget([
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => ['class' => 'table bordered'],
                    'dataProvider' => $dataProvider,
                    'rowOptions' => function ($model) {
                        /* @var $model \common\models\Games */
                        if ($model->winner_id == Yii::$app->user->id) {
                            return ['class' => 'bg-success'];
                        }
                        else {
                            return ['class' => 'bg-danger'];
                        }
                    },
                    'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'label' => 'حریف',
                            'format' => 'raw',
                            'value' => function ($model) {
                                /* @var $model \common\models\Games */
                                $id = $model->player_1;
                                $fullname = $model->player1->fullname;
                                if ($model->player_1 == Yii::$app->user->id) {
                                    $id = $model->player_2;
                                    $fullname = $model->player2->fullname;
                                }
                                return Html::a($fullname, ['/users/view', 'id' => $id], ['class' => 'text-white']);
                            }
                        ],
                            [
                            'attribute' => 'type_id',
                            'value' => function ($model) {
                                /* @var $model \common\models\Games */
                                return $model->type->title;
                            }
                        ],
                            [
                            'attribute' => 'total_amount',
                            'value' => function ($model) {
                                /* @var $model \common\models\Games */
                                return number_format($model->total_amount) . ' ' . Yii::t('base', 'Toman');
                            }
                        ],
                            [
                            'attribute' => 'finished_at',
                            'contentOptions' => ['style' => 'direction: ltr !important;'],
                            'value' => function ($model) {
                                /* @var $model \common\models\Games */
                                return functions::convertdatetime($model->finished_at);
                            }
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
    <div id="connecting">در حال اتصال به سرور ...</div>
</div>
<script>
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
    var play_url = '<?= Url::to(['play']) ?>/';
    var profile_url = '<?= Url::to(['/profile']) ?>/';
</script>
<?php
$depends = ['depends' => 'frontend\assets\AppAsset'];
$this->registerCssFile('@web/themes/sixpairs/css/games_history.css', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/socket.io.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/node_config.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/games_history.js', $depends);
?>