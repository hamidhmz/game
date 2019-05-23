<?php
/**
 * MorrisAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class MorrisAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/farsidesign/yii2-sbadminrtl/sbadmin/bower_components/';
    public $css = [
		'morrisjs/morris.css',
	];
	public $js = [
        'raphael/raphael-min.js',
        'morrisjs/morris.min.js'
	];
}