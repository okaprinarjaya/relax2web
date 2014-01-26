<?php
require realpath(__DIR__ . '/../vendor/autoload.php');
require realpath(__DIR__ . '/config.php');

use Aura\Includer\Includer as AuraIncluder;

date_default_timezone_set('Asia/Jakarta');
Propel::init("propelconf/connection.php");

$app = new \Slim\Slim(array(
	'view' => new \src\Common\AppTwigViewBase()
));

$app->add(new \src\Common\AppSlimMiddleware());

$app->app_conf = getAppConfig();
$app->input_filter = require realpath(__DIR__ . '/../vendor/aura/filter/scripts/instance.php');

$app->view()->parserOptions = array(
	'debug' => true
);

$app->view()->parserExtensions = array(
	new \Slim\Views\TwigExtension(),
	new Twig_Extension_Debug()
);

$app->view()->setTemplatesDirectory($app->app_conf['templates_dir'].$app->app_conf['template'].'/');
$app->view()->setData('__form_data',array());
$app->view()->setData('__validations',null);


/**
 * 
 * Start to load all routes
 * 
 */
$app->get('/', function () use ($app) {
	$app->render('modules/main/index.html');
});

$modules = $app->app_conf['load_modules'];
array_walk($modules, function (&$v, $k) use ($app) {
	$v = $app->app_conf['modules_dir'].$v;
});

$includer = new AuraIncluder();
$includer->setDirs($modules);
$includer->addFiles(array(
	'*.php'
));

$includer->setVars(array(
	'app' => $app
));

$includer->setStrict(false);
$includer->load();

/**
 * 
 * Go!
 * 
 */
$app->run();
