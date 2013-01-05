<?php
/**
 * SlimTwitt Skeleton
 * A skeleton using Twitter's Bootstrap, Twig and Slim
 * @author Randy Sesser <sesser@gmail.com>
 * @license MIT http://sesser.mit-license.org/
 */

//-- Define some constants
define('SS_ROOT', dirname(__DIR__));
define('SS_APP_PATH', SS_ROOT . '/app');
define('SS_PUB_PATH', SS_ROOT . '/public');

//-- First stop, include the autoload
require SS_ROOT . '/vendor/autoload.php';

//-- Next, bootstrap it
require SS_APP_PATH . '/bootstrap.php';

//-- Include your routes here...
$app = \Slim\Slim::getInstance();
$app->get('/', function() use($app) {
	$app->render('index.twig');
});

//-- RUN!
$app->run();


