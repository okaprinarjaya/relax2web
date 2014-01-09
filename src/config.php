<?php
define('DS', DIRECTORY_SEPARATOR);

function getAppConfig()
{
    $config = array();
	$config['base_url'] = 'http://localhost:8000/';
	$config['common_js'] = array('jquery','bootstrap.min');
	$config['common_js_additional_vars'] = array('base_url' => $config['base_url']);
	$config['upload_dir'] = '/var/www/html/uploads';
	
	return $config;
}