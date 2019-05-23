<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = Yii::t('base', 'Dashboard');
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="blocks">
                <h3 class="pull-right blocks-header">کاربران</h3>
                <i class="pull-left fa fa-users fa-3x"></i>
                <div class="clearfix"></div>
                <div class="blocks-footer">
                    <a class="pull-right" href="<?= Url::to(['/users/index']) ?>">لیست کاربران</a>
                    <h3 class="pull-left"><?= $total_users ?></h3>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="blocks">
                <h3 class="pull-right blocks-header">بازی های انجام شده</h3>
                <i class="pull-left fa fa-gamepad fa-3x"></i>
                <div class="clearfix"></div>
                <div class="blocks-footer">
                    <a class="pull-right" href="<?= Url::to(['/games/index']) ?>">لیست بازی</a>
                    <h3 class="pull-left"><?= $total_games ?></h3>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="blocks">
                <div class="">کاربران آنلاین&nbsp;<small class="online-users-count">( ? )</small></div>
                <hr/>
                <ul class="online-users">
                    <li class="text-center">در حال اتصال به سرور ...</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="blocks">
                <div class="">بازی های در حال انجام&nbsp;<small class="online-games-count">( ? )</small></div>
                <hr/>
                <ul class="online-games">
                    <li class="text-center">در حال اتصال به سرور ...</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
</script>
<?php
$depends = ['depends' => 'backend\assets\AppAsset'];
$this->registerCssFile("@web/themes/backgammon/css/style.css", $depends);
$this->registerJsFile("@web/themes/backgammon/js/socket.io.js", $depends);
$this->registerJsFile("@web/themes/backgammon/js/node_config.js", $depends);
$this->registerJsFile("@web/themes/backgammon/js/site_index.js", $depends);
?>