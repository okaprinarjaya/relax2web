<?php
require 'vendor/autoload.php';
require 'src/config.php';

date_default_timezone_set('Asia/Jakarta');
Propel::init("propelconf/connection.php");

$app = new \Slim\Slim(array(
	'view' => new \src\Common\AppTwigViewBase()
));

$app->app_conf = getAppConfig();
$view = $app->view();

$view->parserOptions = array(
	'debug' => true
);

$view->parserExtensions = array(
	new \Slim\Views\TwigExtension()
);

$view->setTemplatesDirectory($app->app_conf['templates_dir'].$app->app_conf['template'].'/');

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