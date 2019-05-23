<?php
use yii\helpers\Url;
use common\config\components\functions;
/* @var $lig \common\models\Ligs */
/* @var $game \common\models\LigsGames */
/* @var $user \common\models\Users */
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Ligs Details');
$players = $lig->ligsPlayers;
?>
<div class="ligs-view">
    <div class="grey darken-3 white-text">
        <?php
        if ($lig->status_id == 1) {
            ?>
            <table class="responsive-table">
                <thead class="hide-on-med-and-down">
                    <tr>
                        <th colspan="2" style="text-align: center;">
                            <span>لیست بازیکنان <small>( <?= $lig->title ?> )</small></span>
                            <small class="right"><?= $lig->status->title ?></small>
                            <small class="left">شروع بازی در <span style="direction: ltr;display: inline-block;"><?= substr(functions::convertdatetime($lig->start_date . ' ' . $lig->start_time), 0, -3) ?></span></small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($players as $player) {
                        /* @var $player \common\models\LigsPlayers */
                        ?>
                        <tr>
                            <td style="width: 150px;text-align: center;"><img src="<?= Yii::getAlias('@web/uploads/users/avatar/' . $player->player->avatar) ?>" width="100" height="100"/></td>
                            <td><?= $player->player->fullname ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>  
            <?php
        }
        else {
            ?>
            <div style="text-align: center;padding: 15px;border-bottom: 1px solid #CCC;">
                <span>لیست بازی ها <small>( <?= $lig->title ?> )</small></span>
                <small class="right"><?= $lig->status->title ?></small>
                <small class="left">شروع بازی در <span style="direction: ltr;display: inline-block;"><?= substr(functions::convertdatetime($lig->start_date . ' ' . $lig->start_time), 0, -3) ?></span></small>
            </div>
            <table class="responsive-table bordered">
                <tbody>
                    <?php
                    $ligsGames = $lig->getLigsGames()->orderBy(['id' => SORT_DESC])->all();
                    echo '<tr>';
                    $i = 0;
                    $r = 2;
                    $arr = functions::a($lig->players_count);
                    foreach ($ligsGames as $ligsGame) {
                        /* @var $ligsGame \common\models\LigsGames */
                        $colspan = ($lig->players_count / $r);
                        echo '<td colspan="' . $colspan . '" style="width: ' . ((100 / ($lig->players_count / 2)) * $colspan) . '%;vertical-align: middle;">';
                        echo '<p style="text-align: center;">';
                        echo ($ligsGame->player1 ? $ligsGame->player1->fullname : '---');
                        echo ' vs ';
                        echo ($ligsGame->player2 ? $ligsGame->player2->fullname : '---');
                        echo '</p>';
                        echo '<p style="text-align: center;">' . $ligsGame->status->title . '</p>';
                        if ($ligsGame->status_id == 4) {
                            echo '<p style="text-align: center;">برنده: ' . ($ligsGame->winner ? $ligsGame->winner->fullname : '---') . '</p>';
                        }
                        else if ($ligsGame->status_id == 3 && ($user->id == $ligsGame->player_1 || $user->id == $ligsGame->player_2)) {
                            echo '<p style="text-align: center;"><a href="' . Url::to(['play']) . '" class="waves-effect btn">ورود</a></p>';
                        }
                        echo '<p style="text-align: center;" id="pending' . $ligsGame->id . '"></p>';
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
            <?php
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    var username = '<?= $user->username ?>';
    var password = '<?= $user->password_hash ?>';
    var ligs_play_url = '<?= Url::to(['play']) ?>/';
    var ligs_view_url = '<?= Url::to(['view']) ?>/';
</script>
<?php
$depends = ['depends' => 'frontend\assets\AppAsset'];
$this->registerJsFile('@web/themes/sixpairs/js/socket.io.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/node_config.js', $depends);
$this->registerJsFile('@web/themes/sixpairs/js/ligs_view.js', $depends);
$this->registerCss("
@media only screen and (max-width: 992px) {
    table.responsive-table tbody tr {
        vertical-align: middle;
    }
}
");
?>