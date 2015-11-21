<?php

namespace src\template\twig\node;

class includecss extends \src\template\twig\node\includeasset
{
	/**
	* {@inheritdoc}
	*/
	public function get_definition_name()
	{
		return 'STYLESHEETS';
	}

	/**
	* {@inheritdoc}
	*/
	public function append_asset(\Twig_Compiler $compiler)
	{
		$compiler
			->raw("<link href=\"' . ")
			->raw("\$asset_file . '\"")
			->raw(' rel="stylesheet" type="text/css" media="screen, projection" />')
		;
	}
}
