<?php
/**
 * SbAdminAsset.php
 *
 * @copyright Copyright &copy; Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class SbAdminAsset extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/farsidesign/yii2-sbadminrtl/sbadmin/dist';
	public $css = [
		'css/sb-admin-2.css',
        'css/sb-admin-2-rtl.css',
	];
	public $js = [
        'js/sb-admin-2.js'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'rmrevin\yii\fontawesome\AssetBundle',
        'airani\bootstrap\BootstrapRtlAsset',
	];
}