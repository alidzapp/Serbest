<?php


namespace src\template\twig\node;

class includejs extends \src\template\twig\node\includeasset
{
	/**
	* {@inheritdoc}
	*/
	public function get_definition_name()
	{
		return 'SCRIPTS';
	}

	/**
	* {@inheritdoc}
	*/
	protected function append_asset(\Twig_Compiler $compiler)
	{
		$config = $this->environment->get_src_config();

		$compiler
			->raw("<script type=\"text/javascript\" src=\"' . ")
			->raw("\$asset_file")
			->raw(". '\"></script>\n")
		;
	}
}
