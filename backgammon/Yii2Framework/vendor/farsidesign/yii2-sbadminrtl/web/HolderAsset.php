<?php
/**
 * HolderAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class HolderAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/imsky/holder';
	public $js = [
        'holder.min.js',
	];
}