<?php

if($_SERVER['REQUEST_URI'] == "/index.php") {
header("Location: /",TRUE,301);
exit();
}

if($_SERVER['HTTP_HOST']=='YP:8443'){
defined('YII_DEBUG') or define('YII_DEBUG',true);
$yii=dirname(__FILE__).'/yii/yii.php';
$config=dirname(__FILE__).'/protected/config/local_main.php';
}

else {
define('YII_DEBUG', false);
$yii=dirname(__FILE__).'/yii/yii.php';
$config=dirname(__FILE__).'/protected/config/server_main.php';
define('YII_ENABLE_ERROR_HANDLER', false);
//define('YII_ENABLE_EXCEPTION_HANDLER', false);
}
require_once($yii);
$app = Yii::createWebApplication($config);
$app->run();