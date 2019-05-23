<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require('../Yii2Framework/vendor/autoload.php');
require('../Yii2Framework/vendor/yiisoft/yii2/Yii.php');
require('../Yii2Framework/common/config/bootstrap.php');
require('../Yii2Framework/backend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require('../Yii2Framework/common/config/main.php'),
    require('../Yii2Framework/common/config/main-local.php'),
    require('../Yii2Framework/backend/config/main.php'),
    require('../Yii2Framework/backend/config/main-local.php')
);

(new yii\web\Application($config))->run();
