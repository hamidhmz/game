<?php
namespace frontend\assets;
use yii\web\AssetBundle;
class AppAsset extends AssetBundle {
    public $basePath = '@webroot/themes/sixpairs';
    public $baseUrl = '@web/themes/sixpairs';
    public $css = [
        //'lib/materialize/css/materialize.min.css',
//        '//cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css',
//        'css/font-awesome.min.css',
        // 'css/style.css',
//        'css/bootstrap.min.css',
//        'css/login.css',

    ];
    public $js = [
        //'lib/materialize/js/materialize.min.js',
        // "js/jquery2.min.js",
//        "js/bootstrap.min.js",
//        "js/login.js",
    ];
    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\web\JqueryAsset',
    //     'macgyer\yii2materializecss\assets\MaterializeAsset',
    //     //'yii\bootstrap\BootstrapAsset',
    // ];
}