<?php

namespace src\template\twig\tokenparser;

class event extends \Twig_TokenParser
{
	/**
	* Parses a token and returns a node.
	*
	* @param \Twig_Token $token A Twig_Token instance
	*
	* @return \Twig_NodeInterface A Twig_NodeInterface instance
	*/
	public function parse(\Twig_Token $token)
	{
		$expr = $this->parser->getExpressionParser()->parseExpression();

		$stream = $this->parser->getStream();
		$stream->expect(\Twig_Token::BLOCK_END_TYPE);

		return new \src\template\twig\node\event($expr, $this->parser->getEnvironment(), $token->getLine(), $this->getTag());
	}

	/**
	* Gets the tag name associated with this token parser.
	*
	* @return string The tag name
	*/
	public function getTag()
	{
		return 'EVENT';
	}
}
