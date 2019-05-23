<?php
/**
 * FlotTooltipAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class FlotTooltipAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/farsidesign/yii2-sbadminrtl/sbadmin/bower_components/flot.tooltip';
    public $css = [
		
	];
	public $js = [
	'js/jquery.flot.tooltip.min.js',
	];
}