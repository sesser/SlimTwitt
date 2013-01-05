<?php 

$config = [
	'slim' => [
		'templates.path' => SS_APP_PATH . '/templates',
		'log.level' => \Slim\Log::DEBUG,
		'log.enabled' => TRUE,
		'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter([
			'path' => SS_APP_PATH . '/logs',
			'name_format' => 'Y-m-d.\l\o\g'
		])
	],
	'twig' => [
		'charset' => 'utf-8',
		'cache' => SS_APP_PATH . '/cache/templates',
		'auto_reload' => TRUE,
		'strict_variables' => FALSE,
		'autoescape' => TRUE
	]
];

$app = new \Slim\Slim($config['slim']);
\Slim\Extras\Views\Twig::$twigOptions = $config['twig'];
$app->view(new \Slim\Extras\Views\Twig());
