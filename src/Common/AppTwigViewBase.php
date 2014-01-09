<?php
namespace src\Common;

class AppTwigViewBase extends \Slim\Views\Twig
{

    private $js = array();
    private $js_dynamic_vars = array();
	private $app_config;

	public function __construct()
	{
	   parent::__construct();
	   $this->app_config = getAppConfig();
	   $this->setData('__base_url', $this->app_config['base_url']);
	}

    public function addJavascript($js, $additional_dynamic_vars = array())
	{
	    array_push($this->js, $js);

	    if (count($additional_dynamic_vars) > 0) {
	    	$split = explode("/",$js);
	    	$js_filename = end($split);
	    	$vars = array();

	    	foreach ($additional_dynamic_vars as $key => $value) {
	    		$vars[$js_filename.'_'.$key] = $value;
	    	}

	    	if (count($this->js_dynamic_vars) > 0) {
	    		array_merge($this->js_dynamic_vars, $vars);
	    	} else {
	    		$this->js_dynamic_vars = $vars;
	    	}
	    	
	    }
	}

	public function render($template, $data = null)
	{
		// Prepare javascripts
	   $javascripts = array_merge($this->app_config['common_js'], $this->js);

	   array_walk($this->app_config['common_js_additional_vars'], function (&$value, $key) {
	   	    $value = is_string($value) ? "'$value'" : $value;
	   });

	   array_walk($this->js_dynamic_vars, function (&$value, $key) {
	   	    $value = is_string($value) ? "'$value'" : $value;
	   });

	   $javascripts_additional_vars = array_merge($this->app_config['common_js_additional_vars'], $this->js_dynamic_vars);

	   $this->setData('__default_javascript', $javascripts);
	   $this->setData('__javascript_additional_vars', $javascripts_additional_vars);

		return parent::render($template, $data);
	}
}