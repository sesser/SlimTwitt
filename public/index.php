<?php
/**
 * SlimTwitt Skeleton
 * A skeleton using Twitter's Bootstrap, Twig and Slim
 * @author Randy Sesser <sesser@gmail.com>
 * @license MIT http://sesser.mit-license.org/
 */

//-- Define some constants
define('ST_ROOT', dirname(__DIR__));
define('ST_APP_PATH', ST_ROOT . '/app');
define('ST_PUB_PATH', ST_ROOT . '/public');

require ST_APP_PATH . '/bootstrap.php';


if (!isset($app))
	$app = \Slim\Slim::getInstance();

//-- RUN!
$app->run();


