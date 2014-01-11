<?php
$app->get('/example_module', function () use ($app) {
	$pubs = \src\Orm\PublisherQuery::create()->find();
	$authors = \src\Orm\AuthorQuery::create()->find();
	$books = \src\Orm\BookQuery::create()->find();

	$app->view()->addJavascript('example_module/example_module', array(
		'datetime' => date('Y-m-d H:i:s'),
		'userid' => 99
	));
	
	$app->render('modules/example_module/index.html', array(
		'pubs' => $pubs, 
		'authors' => $authors,
		'books' => $books
	));
});

$app->post('/example_module', function () use ($app) {
	$book = new \src\Orm\Book();
	$book->setTitle($_POST['book_title']);
	$book->setIsbn($_POST['isbn']);
	$book->setPublisherId($_POST['publisher']);
	$book->setAuthorId($_POST['author']);

	$book->save();

	$app->redirect('/example_module');
});