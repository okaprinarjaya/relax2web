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
	// Validation phase
	$filter = $app->input_filter;
	
	$filter->addSoftRule('book_title', $filter::IS_NOT, 'blank');
	$filter->addSoftRule('isbn', $filter::IS_NOT, 'blank');
	$filter->addSoftRule('publisher', $filter::IS_NOT, 'blank');
	$filter->addSoftRule('author', $filter::IS_NOT, 'blank');

	if (!$filter->values($_POST)) {
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
			'books' => $books,
			'validations' => $filter->getMessages()
		));

	// Data processing phase (After validation)
	} else {
		$book = new \src\Orm\Book();
		$book->setTitle($_POST['book_title']);
		$book->setIsbn($_POST['isbn']);
		$book->setPublisherId($_POST['publisher']);
		$book->setAuthorId($_POST['author']);

		$book->save();
		$app->redirect('/example_module');
	}
});