<?php
$app->get('/example_module_dua', function () use ($app) {
	$pubs = \src\Orm\PublisherQuery::create()->find();
	$app->render('modules/example_module_dua/index.html', array('pubs' => $pubs));
});