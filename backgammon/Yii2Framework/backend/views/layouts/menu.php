<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li><?= Html::a('<i class="fa fa-fw fa-dashboard"></i> ' . Yii::t('base', 'Dashboard'), ['/site/index']) ?></li>
            <li>
                <?= Html::a('<i class="fa fa-fw fa-users"></i> ' . Yii::t('base', 'Users') . ' <span class="fa arrow"></span>', '#') ?>
                <?=
                Nav::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'nav nav-second-level'],
                    'items' => [
                        ['label' => Yii::t('base', 'Create User'), 'url' => ['/users/create']],
                        ['label' => Yii::t('base', 'Users Management'), 'url' => ['/users/index']],
                    ],
                ])
                ?>
            </li>
            <li>
                <?= Html::a('<i class="fa fa-fw fa-sitemap"></i> ' . Yii::t('app', 'Ligs') . ' <span class="fa arrow"></span>', '#') ?>
                <?=
                Nav::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'nav nav-second-level'],
                    'items' => [
                        ['label' => Yii::t('app', 'Create Lig'), 'url' => ['/ligs/create']],
                        ['label' => Yii::t('app', 'لیگ های در انتظار بازیکن'), 'url' => ['/ligs/index1']],
                        ['label' => Yii::t('app', 'لیگ های در انتظار شروع بازی'), 'url' => ['/ligs/index2']],
                        ['label' => Yii::t('app', 'لیگ های در حال بازی'), 'url' => ['/ligs/index3']],
                        ['label' => Yii::t('app', 'لیگ های اتمام یافته'), 'url' => ['/ligs/index4']],
                    ],
                ])
                ?>
            </li>
            <li><?= Html::a('<i class="fa fa-fw fa-gamepad"></i> ' . Yii::t('app', 'Games Don'), ['/games/index']) ?></li>
            <li>
                <?= Html::a('<i class="fa fa-fw fa-map"></i> ' . Yii::t('app', 'Provinces and Cities') . ' <span class="fa arrow"></span>', '#') ?>
                <?=
                Nav::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'nav nav-second-level'],
                    'items' => [
                        ['label' => Yii::t('app', 'Provinces'), 'url' => ['/provinces/index']],
                        ['label' => Yii::t('app', 'Cities'), 'url' => ['/cities/index']],
                    ],
                ])
                ?>
            </li>
            <li><?= Html::a('<i class="fa fa-fw fa-cogs"></i> ' . Yii::t('base', 'Settings'), ['/settings/index']) ?></li>
            <li><?= Html::a('<i class="fa fa-fw fa-globe"></i> ' . Yii::t('base', 'مشاهده سایت'), ['../site/index'], ['target' => '_blank']) ?></li>
            <li class="visible-xs"><?= Html::a('<i class="fa fa-fw fa-sign-out"></i> ' . Yii::t('base', 'Logout'), ['/site/logout']) ?></li>
        </ul>
    </div>
</div>