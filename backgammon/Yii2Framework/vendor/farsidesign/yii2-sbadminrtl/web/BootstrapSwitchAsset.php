<?php
/**
 * BootstrapSwitchAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class BootstrapSwitchAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/nostalgiaz/bootstrap-switch/dist';
    public $css = [
		'css/bootstrap3/bootstrap-switch.min.css',
	];
	public $js = [
        'js/bootstrap-switch.min.js',
	];
}