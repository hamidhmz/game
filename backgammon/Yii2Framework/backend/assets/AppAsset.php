<?php
namespace backend\assets;
use yii\web\AssetBundle;
class AppAsset extends AssetBundle {
    public $basePath = '@webroot/themes/classic';
    public $baseUrl = '@web/themes/classic';
    public $css = [
//        'css/bootstrap-rtl.min.css',
        'css/font-awesome.min.css',
        'css/style.css',
        'css/form.css',
    ];
    public $js = [
//        'assets/backend/js/icheck.js',
//        'assets/backend/js/init.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'farsidesign\sbadminrtl\web\SbAdminAsset',
        'farsidesign\sbadminrtl\web\MetisMenuAsset',
//        'farsidesign\sbadminrtl\web\FontsAsset',
//        'farsidesign\sbadminrtl\web\DataTablesAsset',
//        'farsidesign\sbadminrtl\web\HolderAsset',
//        'farsidesign\sbadminrtl\web\BootstrapSwitchAsset',
//        'farsidesign\sbadminrtl\web\MorrisAsset',
//        'farsidesign\sbadminrtl\web\FlotChartsAsset',
//        'farsidesign\sbadminrtl\web\FlotTooltipAsset',
//        'farsidesign\sbadminrtl\web\TimeLineAsset',
    ];
}