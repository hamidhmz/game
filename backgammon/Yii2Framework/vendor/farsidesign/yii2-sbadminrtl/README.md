SB Admin RTL Yii 2 Framework
============================
SB Admin RTL from Start Bootstrap as a backend UI for Yii 2 Framework

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist farsidesign/yii2-sbadminrtl "dev-master"
```

or add

```
"farsidesign/yii2-sbadminrtl": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/farsidesign/yii2-sbadminrtl/views/yiisoft',
                ],
            ],
        ],
```
```php
'components' => [
        'i18n' => [
        'translations' => [
            'sbadmin' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@vendor/farsidesign/yii2-sbadminrtl/messages',
                'sourceLanguage' => 'fa-IR',
                'fileMap' => [
                   'sbadmin' => 'sbadmin.php',
                ],
            ],
        ],
    ],
],
```
The register lines for all assets...
```php
farsidesign\sbadminrtl\web\SbAdminAsset::register($this);
farsidesign\sbadminrtl\web\MetisMenuAsset::register($this);
farsidesign\sbadminrtl\web\FontsAsset::register($this);
farsidesign\sbadminrtl\web\DataTablesAsset::register($this);
farsidesign\sbadminrtl\web\HolderAsset::register($this);
farsidesign\sbadminrtl\web\BootstrapSwitchAsset::register($this);
farsidesign\sbadminrtl\web\MorrisAsset::register($this);
farsidesign\sbadminrtl\web\FlotChartsAsset::register($this);
farsidesign\sbadminrtl\web\FlotTooltipAsset::register($this);
farsidesign\sbadminrtl\web\TimeLineAsset::register($this);
```
