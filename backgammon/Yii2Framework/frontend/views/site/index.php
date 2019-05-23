<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'صفحه ی اصلی';

?>
<div class="container">
    <div class="row">
        <div class="slider col ">
            <ul class="slides">
                <li>
                    <img src="<?= Url::to(['/themes/classic/images/s3.jpg']) ?>"/> <!-- random image -->
                    <div class="caption center-align">
                        <h3>This is our big Tagline!</h3>
                        <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                    </div>
                </li>
                <li>
                    <img src="<?= Url::to(['/themes/classic/images/s1.jpg']) ?>"/> <!-- random image -->
                    <div class="caption left-align">
                        <h3>Left Aligned Caption</h3>
                        <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                    </div>
                </li>
                <li>
                    <img src="<?= Url::to(['/themes/classic/images/s3.jpg']) ?>"/>
                    <div class="caption right-align">
                        <h3>Right Aligned Caption</h3>
                        <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="grey darken-4">
    <div class="container">
        <div class="row">
            <div class="col xl12">
                <h3 style="text-align: center;color: #ffffff" >بهترین بازیکنان</h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col s12 m3">
                <div class="card">
                    <div class="card-image ">
                        <img src="<?= Url::to(['/themes/classic/images/1.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light blue"><i class="material-icons"> person</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card">
                    <div class="card-image">
                        <img src="<?= Url::to(['/themes/classic/images/1.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons"> person</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card">
                    <div class="card-image">
                        <img src="<?= Url::to(['/themes/classic/images/1.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light brown"><i class="material-icons"> person</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card">
                    <div class="card-image">
                        <img src="<?= Url::to(['/themes/classic/images/1.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light green"><i class="material-icons"> person</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col xl12">
                <h3 style="text-align: center;color: #ffffff"> تورنمت های امروز</h3>
            </div>
        </div>
        <hr>
        <div class="row" style="margin-bottom: 0">
            <div class="col s12 m9">
                <div class="card hoverable">
                    <div class="card-image ">
                        <img src="<?= Url::to(['/themes/classic/images/s2.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">games</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card">
                    <div class="card-image">
                        <img src="<?= Url::to(['/themes/classic/images/s2.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">games</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">
                        <img src="<?= Url::to(['/themes/classic/images/s2.jpg']) ?>">
                        <span class="card-title">Card Title</span>
                        <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">games</i></a>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (!Yii::$app->user->isGuest) {
    ?>
    <script>
        var username = '<?= $user->username ?>';
        var password = '<?= $user->password_hash ?>';
    </script>
    <?php
}
$this->registerJsFile(Url::to(['@web/themes/sixpairs/css/slider/sliderengine/amazingslider.js']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerJsFile(Url::to(['@web/themes/sixpairs/css/slider/sliderengine/initslider-1.js']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerCssFile(Url::to(['@web/themes/sixpairs/css/slider/sliderengine/amazingslider-1.css']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerJsFile(Url::to(['/themes/classic/js/socket.io.js']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerJsFile(Url::to(['/themes/classic/js/node_config.js']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerJsFile(Url::to(['/themes/classic/js/site_index.js']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerJs("$('.slider').slider();");
?>