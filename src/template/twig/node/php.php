<?php


namespace src\template\twig\node;

class php extends \Twig_Node
{
	/** @var \Twig_Environment */
	protected $environment;

	public function __construct(\Twig_Node_Text $text, \src\template\twig\environment $environment, $lineno, $tag = null)
	{
		$this->environment = $environment;

		parent::__construct(array('text' => $text), array(), $lineno, $tag);
	}

	/**
	* Compiles the node to PHP.
	*
	* @param \Twig_Compiler A Twig_Compiler instance
	*/
	public function compile(\Twig_Compiler $compiler)
	{
		$compiler->addDebugInfo($this);

		$config = $this->environment->get_src_config();

		if (!$config['tpl_allow_php'])
		{
			$compiler
				->write("// PHP Disabled\n")
			;

			return;
		}

		$compiler
			->raw($this->getNode('text')->getAttribute('data'))
		;
	}
}
