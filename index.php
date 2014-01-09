<?php
require 'vendor/autoload.php';
require 'src/config.php';

date_default_timezone_set('Asia/Jakarta');
Propel::init("propelconf/connection.php");

$app = new \Slim\Slim(array(
	'view' => new \src\Common\AppTwigViewBase()
));

$view = $app->view();

$view->parserOptions = array(
	'debug' => true
);

$view->parserExtensions = array(
	new \Slim\Views\TwigExtension()
);

$view->setTemplatesDirectory('src/Template/CustomExample/');
$app->add(new \src\Common\AppSlimMiddleware());

/**
 * 
 * Start to set default routes.
 * 
 */
$app->get('/', function () use ($app) {
	$app->render('modules/main/index.html');
});

$app->run();