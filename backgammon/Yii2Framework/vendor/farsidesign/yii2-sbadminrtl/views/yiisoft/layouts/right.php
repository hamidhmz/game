<?php
/**
 * right.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
          <ul class="nav" id="side-menu">
                    <li>
                    <?= Html::a(
				        '<i class="fa fa-dashboard fa-fw"></i> '.Yii::t('sbadmin','Dashboard'),
				        Url::to(Yii::$app->homeUrl)
			             ) ?>
                    </li>
                    <li>
				    <a href="#"><i class="fa fa-wrench fa-fw"></i> <?=Yii::t('sbadmin','Demo')?><span class="fa arrow"></span></a>
				    <?= Nav::widget([
					'encodeLabels' => false,
					'options' => ['class' => 'nav nav-second-level'],
					'items' => [
						['label' => 'Panels and Wells', 'url' => ['/site/page', 'view' => 'panels-wells']],
						['label' => 'Buttons', 'url' => ['/site/page', 'view' => 'buttons']],
						['label' => 'Notifications', 'url' => ['/site/page', 'view' => 'notifications']],
						['label' => 'Typography', 'url' => ['/site/page', 'view' => 'typography']],
						['label' => ' Icons', 'url' => ['/site/page', 'view' => 'icons']],
						['label' => 'Grid', 'url' => ['/site/page', 'view' => 'grid']],
					],
				    ]) ?>
			        </li>
                    
                    <li>
                    <?= Html::a(
				        '<i class="fa fa-sign-out fa-fw"></i> '.Yii::t('sbadmin','Logout'),
				        Url::to(['/site/logout'],['data-method' => 'post'])
			             ) ?>
                    </li>
           </ul>
     </div>
                <!-- /.sidebar-collapse -->
            </div>