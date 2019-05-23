<?php
/**
 * FlotChartsAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class FlotChartsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/farsidesign/yii2-sbadminrtl/sbadmin/bower_components/flot';
    public $css = [
		
	];
	public $js = [
    'jquery.flot.js',
	'jquery.flot.pie.js',
	'jquery.flot.resize.js',
	'jquery.flot.time.js',
	];
}