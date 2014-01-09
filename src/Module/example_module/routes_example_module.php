<?php
$app->get('/example_module', function () use ($app) {
	$pubs = \src\Orm\PublisherQuery::create()->find();

	$app->view()->addJavascript('example_module/example_module', array(
		'datetime' => date('Y-m-d H:i:s'),
		'userid' => 99
	));
	
	$app->render('modules/example_module/index.html', array('pubs' => $pubs));
});