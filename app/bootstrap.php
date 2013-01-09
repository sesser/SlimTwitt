<?php 
require_once ST_ROOT . '/vendor/autoload.php';
include_once ST_APP_PATH . '/controllers/Controller.php';

$config = [
	'slim' => [
		'templates.path' => ST_APP_PATH . '/templates',
		'log.level' => \Slim\Log::DEBUG,
		'log.enabled' => TRUE,
		'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter([
			'path' => ST_ROOT . '/tmp/logs',
			'name_format' => 'Y-m-d'
		])
	],
	'twig' => [
		'charset' => 'utf-8',
		'cache' => ST_ROOT . '/tmp/cache/templates',
		'auto_reload' => TRUE,
		'strict_variables' => FALSE,
		'autoescape' => TRUE
	]
];

//-- load up the Slim app
$app = new \Slim\Slim($config['slim']);
//-- Configure the views
\Slim\Extras\Views\Twig::$twigOptions = $config['twig'];
$app->view(new \Slim\Extras\Views\Twig());

//-- Set up the routes
foreach (Config::get('app.routes') as $path => $route) {
	
}
