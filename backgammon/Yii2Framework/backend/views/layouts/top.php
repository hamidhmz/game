<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?= Html::a($settings->site_title, ['/site/index'], ['class' => 'navbar-brand']) ?>
</div>
<ul class="nav navbar-top-links navbar-right">
</ul>
<ul class="nav navbar-top-links navbar-left hidden-xs">
    <li><a href="<?= Url::to(['/site/logout']) ?>"><i class="fa fa-sign-out fa-fw"></i> <?= Yii::t('base', 'Logout') ?></a></li>
</ul>