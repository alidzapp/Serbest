<?php

/**
* DO NOT CHANGE
*/
if (!defined('IN_src'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}



$lang = array_merge($lang, array(
	'CONTROLLER_ARGUMENT_VALUE_MISSING'	=> 'Missing value for argument #%1$s: <strong>%3$s</strong> in class <strong>%2$s</strong>',
	'CONTROLLER_NOT_SPECIFIED'			=> 'No controller has been specified.',
	'CONTROLLER_METHOD_NOT_SPECIFIED'	=> 'No method was specified for the controller.',
	'CONTROLLER_SERVICE_UNDEFINED'		=> 'The service for controller "<strong>%s</strong>" is not defined in ./config/services.yml.',
));
