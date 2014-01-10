<?php
namespace src\Common;

use Aura\Includer\Includer as AuraIncluder;

class AppSlimMiddleware extends \Slim\Middleware
{
	public function call()
	{
		$app = $this->app;

		$app->hook('slim.before', function () use ($app) {
			$splitRoute = explode('/', $app->environment()['PATH_INFO']);
			$moduleName = $splitRoute[1];

			if (strlen($moduleName) != 0 && realpath($app->app_conf['modules_dir'].$moduleName)) {
				$includer = new AuraIncluder();

				$includer->setDirs(array(
					$app->app_conf['modules_dir'].$moduleName
				));

				$includer->addFiles(array(
					'*.php'
				));

				$includer->setVars(array(
					'app' => $app
				));

				$includer->setStrict(false);
				$includer->load();
			}

		});

		$this->next->call();
	}
}