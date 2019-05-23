<?php
/**
 * DataTablesAsset.php
 *
 * @copyright Copyright Moslem Mobarakeh, https://github.com/farsidesign, 2016
 * @author Moslem Mobarakeh
 * @package farsidesign/yii2-sbadminrtl
 * @license MIT
 */
namespace farsidesign\sbadminrtl\web;
class DataTablesAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/datatables/datatables/media';
	public $css = [
		'css/dataTables.bootstrap.css',
		'https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css',
	];
	public $js = [
        'js/jquery.dataTables.min.js',
	    'js/dataTables.bootstrap.min.js',
        'https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js'
	];
}