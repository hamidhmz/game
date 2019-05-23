<?php
use yii\helpers\Html;
use common\config\components\Breadcrumbs2;
use farsidesign\sbadminrtl\widgets\Alert;
use common\models\Settings;
/* @var $this \yii\web\View */
/* @var $content string */
$settings = Settings::findOne(1);
backend\assets\AppAsset::register($this);
if (Yii::$app->user->isGuest) {
    echo $this->render('login', ['content' => $content, 'settings' => $settings]);
}
else {
    $this->beginPage();
    ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= $settings->site_title . ' / ' . $this->title ?></title>
            <?php $this->head() ?>
        </head>
        <body>
            <?php $this->beginBody() ?>
            <div class="wrapper">
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <?= $this->render('top.php', ['settings' => $settings]) ?>
                </nav>
                <?= $this->render('menu.php', ['settings' => $settings]) ?>
                <div id="page-wrapper">
                    <?= Breadcrumbs2::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
                    <div class="container-fluid">
                        <?= Alert::widget() ?>
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