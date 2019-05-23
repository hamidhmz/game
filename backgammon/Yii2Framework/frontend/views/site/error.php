<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
$this->title = $name;
?>
<div class="site-error">
    <div class="row">
        <div class="col xl3 l4 m3 s12"></div>
        <div class="col xl6 l4 m6 s12">
            <div class="card">
                <div class="card-image">
                    <img src="images/sample-1.jpg">
                    <span class="card-title">Card Title</span>
                </div>
                <div class="card-content" style="text-align: center;">
                    <h4 style="direction: ltr;text-align: center;"><?= Html::encode($this->title) ?></h4>
                    <?= nl2br(Html::encode($message)) ?>
                </div>
                <div class="card-action">
                    <?php
                    if (Yii::$app->user->isGuest) {
                        ?>
                        <a href="<?= Url::to(['/site/login']) ?>"><?= Yii::t('base', 'Login') ?></a>
                        <?php
                    }
                    else {
                        ?>
                        <a href="<?= Url::to(['/games/index']) ?>"><?= Yii::t('base', 'Home') ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>