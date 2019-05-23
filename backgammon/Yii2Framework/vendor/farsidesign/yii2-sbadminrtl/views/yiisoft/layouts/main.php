<?php
/**
 * main.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use farsidesign\sbadminrtl\widgets\Alert;
farsidesign\sbadminrtl\web\SbAdminAsset::register($this);
farsidesign\sbadminrtl\web\MetisMenuAsset::register($this);
farsidesign\sbadminrtl\web\FontsAsset::register($this);
//farsidesign\sbadminrtl\web\DataTablesAsset::register($this);
//farsidesign\sbadminrtl\web\HolderAsset::register($this);
//farsidesign\sbadminrtl\web\BootstrapSwitchAsset::register($this);
//farsidesign\sbadminrtl\web\MorrisAsset::register($this);
//farsidesign\sbadminrtl\web\FlotChartsAsset::register($this);
//farsidesign\sbadminrtl\web\FlotTooltipAsset::register($this);
farsidesign\sbadminrtl\web\TimeLineAsset::register($this);


if (Yii::$app->controller->action->id === 'login') { 
    echo $this->render(
        'login',
        ['content' => $content]
    );
} else {
    $this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script type="text/javascript" src="src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php $this->beginBody() ?>
	<div class="wrapper">

		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

			<?= $this->render('top.php', []) ?>

			<?= $this->render('right.php', []) ?>

		</nav>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $this->title; ?></h1>
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= Alert::widget() ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <?= $content ?>
            </div>
        </div>
        
   

	</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php 
$this->endPage();
}
?>