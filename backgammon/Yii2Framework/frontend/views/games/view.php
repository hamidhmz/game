<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $user \common\models\Users */
/* @var $model common\models\Games */
$this->title = $model->type->title;
?>
<div class="games-view" style="min-height: 290px;">

     <div class="row">
        <div class="col-sm-12" style="margin: 30px 0;">
            
             <div class="col-sm-12 text-white" style="margin: 20px 0; font-size: 16px">
                کاربر گرامی لطفا منتظر باشید تا کسی حریف شما برای بازی کردن شود ...
            </div>
            
        </div>
    </div>
<hr>

    <div class="row" style="margin-bottom: 0;">
        <div class="col-xs-12 col-sm-3 pull-right">
            <div class="grey darken-3 text-white waiting-tables" style="margin: 0 0 30px 0;">
                <div class="title" style="font-size: 16px">اطلاعات بازی</div>

                <div class="card-stacked" dir="rtl">
                    <div class="card-content" style="padding: 50px 0">
                        <div>
                            <strong style="display: inline-block;">نوع بازی :&nbsp;&nbsp;&nbsp;&nbsp; </strong>
                            <p style="display: inline-block;"><?= $model->type->title ?></p>
                        </div>
                        <div>
                            <strong style="display: inline-block;">مبلغ بازی :&nbsp;&nbsp;&nbsp;&nbsp; </strong>
                            <p style="display: inline-block;"><?= number_format($model->amount) ?> تومان</p>
                        </div>
                    </div>
                    <div class="card-action">
                        <a class="btn btn-danger pull-right" id="cancel" href="#">لغو بازی</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 pull-right" style="border-right: 1px solid #fff">
            <div class="grey darken-3 text-white waiting-tables">
                <div class="title" style="font-size: 16px">میزهای بازی</div>
                <div class="list">
                    <div class="header">
                        <div class="row">
                            <div class="col-xs-1 pull-right">#</div>
                            <div class="col-xs-3 pull-right">حریف</div>
                            <div class="col-xs-2 pull-right">نوع بازی</div>
                            <div class="col-xs-3 pull-right">مبلغ پیشنهادی</div>
                            <div class="col-xs-3 pull-right">جزئیات</div>
                        </div>
                    </div>
                    <div class="body"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="connecting">در حال اتصال به سرور ...</div>
</div>
<script type="text/javascript">
    var user_id = '<?= $user->id ?>';
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
    var play_url = '<?= Url::to(['play']) ?>/';
    var profile_url = '<?= Url::to(['/profile']) ?>/';
    var games_list_url = '<?= Url::to(['/games/index']) ?>/';
    var game_id = '<?= $model->id ?>';
</script>
<?php
$options = ['depends' => 'frontend\assets\AppAsset'];
$this->registerCssFile('@web/themes/sixpairs/css/games_index.css', $options);
$this->registerCssFile('@web/themes/sixpairs/css/games_view.css', $options);
$this->registerJsFile('@web/themes/sixpairs/js/socket.io.js', $options);
$this->registerJsFile('@web/themes/sixpairs/js/node_config.js', $options);
$this->registerJsFile('@web/themes/sixpairs/js/games_view.js', $options);
?>