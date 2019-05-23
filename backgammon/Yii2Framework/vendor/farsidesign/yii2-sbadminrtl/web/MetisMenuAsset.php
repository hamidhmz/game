<?php
/**
 * MetisMenuAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class MetisMenuAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/onokumus/metismenu/dist';
	public $css = [
		'metisMenu.min.css',
	];
	public $js = [
        'metisMenu.min.js',
	];
}