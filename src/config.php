<?php
function getAppConfig() {
	return array(
		'base_url' => 'http://localhost:8000/',
		'template' => 'Default',
		'modules_dir' => 'src/Module/',
		'templates_dir' => 'src/Template/',
		'common_js' => array(
			'jquery',
			'bootstrap.min'
		),
		'common_js_additional_vars' => array(
			'base_url' => 'http://localhost:8000/'
			),
		'upload_dir' => '/path/to/upload/dir',
	);
}