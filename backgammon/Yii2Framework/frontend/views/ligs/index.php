<?php
use yii\helpers\Url;
use common\config\components\functions;
/* @var $ligs \common\models\Ligs[] */
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Ligs');
?>
<div class="ligs-index">
    <div class="row">
        <?php
        foreach ($ligs as $lig) {
            /* @var $lig \common\models\Ligs */
            ?>
            <div class="col xl4 l4 m6 s12 right">
                <div class="grey darken-3 white-text">
                    <div style="text-align: center;padding: 15px;background: rgba(0,0,0,0.4)"><?= $lig->title ?></div>
                    <div style="padding: 15px;">
                        <div style="text-align: center;margin-bottom: 10px;">
                            زمان شروع
                            <div style="text-align: center;direction: ltr;">
                                <?= substr(functions::convertdatetime($lig->start_date . ' ' . $lig->start_time), 0, -3) ?>
                            </div>
                        </div>
                        <div style="text-align: center;margin-bottom: 10px;">
                            <?= $lig->type->title . ' / ' . $lig->players_count . ' نفره' ?>
                        </div>
                        <div style="text-align: center;margin-bottom: 10px;">هزینه ورود <?= $lig->amount ? number_format($lig->amount) . ' تومان' : $lig->amount ?></div>
                        <div style="text-align: center;margin-bottom: 10px;">جایزه نفر اول <?= $lig->total_amount ? number_format($lig->total_amount) . ' تومان' : $lig->total_amount ?></div>
                        <div style="text-align: center;margin-bottom: 10px;">تعداد شرکت کننده گان <?= $lig->getLigsPlayers()->count() ?></div>
                        <div style="text-align: center;"><a class="btn waves-effect" href="<?= Url::to(['join', 'id' => $lig->id]) ?>">شرکت در این لیگ</a></div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>