<?php
namespace src\Common;

class AppSlimMiddleware extends \Slim\Middleware
{
	public function call()
	{
		$app = $this->app;

		if ($app->request()->isPost()) {
			$app->view()->setData('__form_data', $_POST);
		}

		// $app->hook('slim.after.dispatch', function () use ($app) {
		// 	if ($app->request()->isPost()) {
		// 		if (!$app->input_filter->getRulesEvaluationResult()) {
		// 			$app->view()->setData('__validations', $app->input_filter->getMessages());
		// 		}
		// 	}
		// });

		$this->next->call();
	}
}