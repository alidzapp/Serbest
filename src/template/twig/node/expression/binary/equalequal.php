<?php


namespace src\template\twig\node\expression\binary;

class equalequal extends \Twig_Node_Expression_Binary
{
	public function operator(\Twig_Compiler $compiler)
	{
		return $compiler->raw('===');
	}
}
