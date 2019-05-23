<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $user \common\models\Users */
$this->title = Yii::t('app', 'Games');
$credit = Yii::$app->user->identity->credit;
?>
<div class="games-index" style="margin: 30px 0">
    <div class="row">
        <div class="col-xl-12  pull-right">
            <a class="btn btn-success" href="<?= Url::to(['/games/create']) ?>"><?= Yii::t('app', 'Create Game') ?></a>
            <a class="btn btn-warning" href="<?= Url::to(['/games/history']) ?>"><?= Yii::t('app', 'History') ?></a>
            <a class="btn btn-danger" href="<?= Url::to(['/users/credit']) ?>">موجودی حساب&nbsp;:&nbsp;<?= $credit ? number_format($credit) . ' تومان' : $credit ?></a>
        </div>
    </div>
    <div style="margin: 30px 0"></div>
    <div class="row" >
        <div class="col-xl-12 col-sm-4 pull-right">
            <div class="grey darken-3 text-white" style="padding: 15px;">
                <div style="margin: 0;border-bottom: 1px solid #AAA;padding: 0 0 15px;">کاربران آنلاین ( <span class="online-users-count">0</span> )</div>
                <ul class="online-users"></ul>
            </div>
        </div>
        <div class="col-xl-12 col-sm-8 pull-left">
            <div class="grey darken-3 text-white waiting-tables">
                <div class="title">میزهای بازی</div>
                <div class="list">
                    <div class="header">
                        <div class="row">
                            <div class="col-xs-1 pull-right">#</div>
                            <div class="col-xs-3 pull-right">حریف</div>
                            <div class="col-xs-2 pull-right">نوع بازی</div>
                            <div class="col-xs-3 pull-right">مبلغ پیشنهادی</div>
                            <div class="col-xs-2 pull-right">جزئیات</div>
                        </div>
                    </div>
                    <div class="body"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="connecting">در حال اتصال به سرور ...</div>
</div>

<!-- 
<div id="wrapper"  style="margin-top: 40px;">
    <div class="row">
        <div class="col-sm-12">
            <a href="" class="btn btn-success">ساخت بازی جدید</a>
            <a href="" class="btn btn-danger">تاریخچه بازی ها</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="panel panel-default">
                <div class="panel-heading rtl">
                    <h3>میزهای بازی موجود</h3> 
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="clearfix">
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <table id="dynamic-table" class="bordered striped responsive-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>حریف</th>
                                        <th >نوع بازی</th>
                                        <th >مبلغ پیشنهادی </th>
                                        <th >عملیات</th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <span>اسمشه</span>
                                        </td>
                                        <td >
                                            <span>بیسبسیب</span>
                                        </td>
                                        <td >
                                            <span>سبسیبسلقل ثقف </span>
                                        </td>
                                        <td >
                                            سب
                                        </td>
                                        

                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
              
            </div>
           
        </div>
       
    </div>
   


</div> -->



<script type="text/javascript">
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
    var play_url = '<?= Url::to(['play']) ?>/';
    var profile_url = '<?= Url::to(['/profile']) ?>/';
</script>
<?php
$depends = ['depends' => 'frontend\assets\AppAsset'];
$this->registerCssFile('@web/themes/sixpairs/css/games_index.css', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/socket.io.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/node_config.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/games_index.js', $depends);
?>