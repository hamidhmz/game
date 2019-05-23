<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $user \common\models\Users */
/* @var $model common\models\Games */

$user_id       = Yii::$app->user->id;
$type_title    = $model->type->title;
$total_amount  = number_format($model->total_amount) . ' تومان';

$player1id     = $model->player_1;
$player1name   = $model->player1->fullname;
$player1dice   = Url::to(['/themes/sixpairs/images/black.png']);
$player1boards = $model->getGamesBoards()->where(['status_id' => 2, 'winner_id' => $player1id])->count();

$player2id     = $model->player_2;
$player2name   = $model->player2->fullname;
$player2dice   = Url::to(['/themes/sixpairs/images/white.png']);
$player2boards = $model->getGamesBoards()->where(['status_id' => 2, 'winner_id' => $player2id])->count();

$this->title = $type_title;
?>
<div class="games-play">
    <div class="visible-mobile" player1>
        <img id="p1img" src="<?= $player1dice ?>"/>
        <div id="p1status" class="<?= $user_id == $player2id ? 'opponent' : '' ?>"></div>
        <div id="p1name"><?= $player1name ?></div>
        <div class="timer1">-</div>
        <div id="p1wins">بردها: <?= $player1boards ?></div>
        <?php
        if ($user_id == $player1id) {
            ?><div class="handover btn">واگذاری ست</div><?php
        }
        ?>
    </div>
    <div class="visible-mobile" player2>
        <img id="p2img" src="<?= $player2dice ?>"/>
        <div id="p2status" class="<?= $user_id == $player1id ? 'opponent' : '' ?>"></div>
        <div id="p2name"><?= $player2name ?></div>
        <div class="timer2">-</div>
        <div id="p2wins">بردها: <?= $player2boards ?></div>
        <?php
        if ($user_id == $player2id) {
            ?><div class="handover btn">واگذاری ست</div><?php
        }
        ?>
    </div>
    <div id="gui">
        <div id="game-board" class="myboard">
            <div class="undo" title="بازگشت"><a class="btn grey lighten-2"></a></div>
            <div id="point-player1-home" class="point" style="<?= $user_id == $player1id ? 'bottom: 4%;right: 0;' : 'top: 4%;left: -1%;' ?>"></div>
            <div id="point-player1-graveyard" class="point" style="<?= $user_id == $player1id ? 'top: 4%;right: 47.5%;' : 'bottom: 4%;right: 47.5%;' ?>"></div>
            <div id="brownDiceNr1Container" class="dice dice-brown hidden" style="top: 44%;<?= $user_id == $player2id ? 'left: 34%;' : 'right: 34%;' ?>"><div id="brownDiceNr1" class="dice brown-three"></div></div>
            <div id="brownDiceNr2Container" class="dice dice-brown hidden" style="top: 44%;<?= $user_id == $player2id ? 'left: 27%;' : 'right: 27%;' ?>"><div id="brownDiceNr2" class="dice brown-three"></div></div>
            <div id="point-player2-home" class="point" style="<?= $user_id == $player1id ? 'top: 4%;right: 0;' : 'bottom: 4%;left: -1%;' ?>"></div>
            <div id="point-player2-graveyard" class="point" style="<?= $user_id == $player1id ? 'bottom: 4%;right: 47.5%;' : 'top: 4%;right: 47.5%;' ?>"></div>
            <div id="whiteDiceNr1Container" class="dice dice-white hidden" style="top: 44%;<?= $user_id == $player2id ? 'right: 34%;' : 'left: 34%;' ?>"><div id="whiteDiceNr1" class="dice white-one"></div></div>
            <div id="whiteDiceNr2Container" class="dice dice-white hidden" style="top: 44%;<?= $user_id == $player2id ? 'right: 27%;' : 'left: 27%;' ?>"><div id="whiteDiceNr2" class="dice white-one"></div></div>
            <div class="board_points">
                <div id="point1" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;right: 9%;' : 'top: 6%;left: 8%;' ?>"></div>
                <div id="point2" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;right: 15%;' : 'top: 6%;left: 14%;' ?>"></div>
                <div id="point3" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;right: 21%;' : 'top: 6%;left: 20%;' ?>"></div>
                <div id="point4" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;right: 27%;' : 'top: 6%;left: 27%;' ?>"></div>
                <div id="point5" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;right: 34%;' : 'top: 6%;left: 33%;' ?>"></div>
                <div id="point6" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;right: 40%;' : 'top: 6%;left: 39%;' ?>"></div>
                <div id="point7" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;left: 39%;' : 'top: 6%;right: 40%;' ?>"></div>
                <div id="point8" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;left: 33%;' : 'top: 6%;right: 34%;' ?>"></div>
                <div id="point9" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;left: 27%;' : 'top: 6%;right: 27%;' ?>"></div>
                <div id="point10" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;left: 20%;' : 'top: 6%;right: 21%;' ?>"></div>
                <div id="point11" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;left: 14%;' : 'top: 6%;right: 15%;' ?>"></div>
                <div id="point12" class="point" style="<?= $user_id == $player1id ? 'bottom: 9%;left: 8%;' : 'top: 6%;right: 8%;' ?>"></div>
                <div id="point13" class="point" style="<?= $user_id == $player1id ? 'top: 6%;left: 8%;' : 'bottom: 9%;right: 9%;' ?>"></div>
                <div id="point14" class="point" style="<?= $user_id == $player1id ? 'top: 6%;left: 14%;' : 'bottom: 9%;right: 15%;' ?>"></div>
                <div id="point15" class="point" style="<?= $user_id == $player1id ? 'top: 6%;left: 20%;' : 'bottom: 9%;right: 21%;' ?>"></div>
                <div id="point16" class="point" style="<?= $user_id == $player1id ? 'top: 6%;left: 27%;' : 'bottom: 9%;right: 27%;' ?>"></div>
                <div id="point17" class="point" style="<?= $user_id == $player1id ? 'top: 6%;left: 33%;' : 'bottom: 9%;right: 34%;' ?>"></div>
                <div id="point18" class="point" style="<?= $user_id == $player1id ? 'top: 6%;left: 39%;' : 'bottom: 9%;right: 40%;' ?>"></div>
                <div id="point19" class="point" style="<?= $user_id == $player1id ? 'top: 6%;right: 40%;' : 'bottom: 9%;left: 39%;' ?>"></div>
                <div id="point20" class="point" style="<?= $user_id == $player1id ? 'top: 6%;right: 34%;' : 'bottom: 9%;left: 33%;' ?>"></div>
                <div id="point21" class="point" style="<?= $user_id == $player1id ? 'top: 6%;right: 27%;' : 'bottom: 9%;left: 27%;' ?>"></div>
                <div id="point22" class="point" style="<?= $user_id == $player1id ? 'top: 6%;right: 21%;' : 'bottom: 9%;left: 20%;' ?>"></div>
                <div id="point23" class="point" style="<?= $user_id == $player1id ? 'top: 6%;right: 15%;' : 'bottom: 9%;left: 14%;' ?>"></div>
                <div id="point24" class="point" style="<?= $user_id == $player1id ? 'top: 6%;right: 8%;' : 'bottom: 9%;left: 8%;' ?>"></div>
            </div>
        </div>
    </div>
    <div id="chat">
        <div id="log"></div>
    </div>
    <div class="players">
        <div class="sixPairs">
            <img src="<?= Url::to(['/themes/sixpairs/images/sixpairs.png']) ?>"/>
        </div>
        <div id="game-sets"><?= $type_title ?></div>
        <div id="gameAmount" style="direction: rtl;"><?= $total_amount ?></div>
        <hr/>
        <div id="player1Name" class="<?= $user_id == $player2id ? 'opponent' : '' ?>"><?= $player1name ?></div>
        <img id="player1Dice" src="<?= $player1dice ?>"/>
        <div class="timer1">-</div>
        <div id="player1Wins">بردها: <?= $player1boards ?></div>
        <?php
        if ($user_id == $player1id) {
            ?><div class="handover btn">واگذاری ست</div><?php
        }
        ?>
        <hr/>
        <div id="player2Name" class="<?= $user_id == $player1id ? 'opponent' : '' ?>"><?= $player2name ?></div>
        <img id="player2Dice" src="<?= $player2dice ?>"/>
        <div class="timer2">-</div>
        <div id="player2Wins">بردها: <?= $player2boards ?></div>
        <?php
        if ($user_id == $player2id) {
            ?><div class="handover btn">واگذاری ست</div><?php
        }
        ?>
    </div>
    <div id="end_game">
      
        <h4>(&nbsp;پایان مسابقه&nbsp;)</h4>
        <hr/>
        <div class="row">
             <div class="col-xs-4 details">
               
                <p>&nbsp;بازنده بازی&nbsp;</p>
                 <div class="user_avatar">
                    <img src="<?= Url::to(['/themes/sixpairs/images/l.png']) ?>" alt="fdf">
                </div> 
                <div style="margin-top: 20px">                    
                     <p style="color: red" id="loserName"></p>
                </div>
            </div>

            <div class="col-xs-4 details">
                <div class="center-money">
                    <img src="<?= Url::to(['/themes/sixpairs/images/handover3.png']) ?>" alt="fdf">
                </div> 
            </div>

            <div class="col-xs-4 details">
                <div class="winner_img">
                    <img src="<?= Url::to(['/themes/sixpairs/images/winner.png']) ?>" alt="fdf">
                </div>
                <p>&nbsp;برنده بازی&nbsp;</p>
                 <div class="user_avatar">
                    <img src="<?= Url::to(['/themes/sixpairs/images/w.png']) ?>" alt="fdf">
                </div> 
                <div style="margin-top: 20px">                    
                    <p style="color: red" id="winnerName"></p>
                </div>
            </div>
        </div>
        
       
       
        <span id="gameAmount2"><?= $total_amount ?></span>
        <br/><br/>
        <div>
            <a class="btn btn-success" href="<?= Url::to(['/games/create']) ?>">ساخت بازی جدید</a>&nbsp;&nbsp;
            <a class="btn btn-primary" href="<?= Url::to(['/games/index']) ?>">لیست بازی ها</a>
        </div>
    </div>
    <div id="connecting">در حال اتصال به سرور ...</div>
</div>
<script type="text/javascript">
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
    var play_url = '<?= Url::to(['play']) ?>/';
    var profile_url = '<?= Url::to(['/profile']) ?>/';
    var game_id = '<?= $model->id ?>';
</script>
<?php
$ver = '1';
$depends = ['depends' => 'frontend\assets\AppAsset'];
$this->registerCssFile('@web/themes/sixpairs/css/games_play.css?ver=' . $ver, $depends);
$this->registerJsFile('@web/themes/sixpairs/js/plugins.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/lib/jquery-ui/jquery-ui.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/lib/jquery-ui/jquery.ui.touch-punch.min.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/socket.io.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/node_config.js?ver=' . $ver, $depends);
$this->registerJsFile('@web/themes/sixpairs/js/games_play.js?ver=' . $ver, $depends);
?>