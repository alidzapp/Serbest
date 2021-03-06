<?php


namespace src\template\twig\tokenparser;

class includephp extends \Twig_TokenParser
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

		$ignoreMissing = false;
		if ($stream->test(\Twig_Token::NAME_TYPE, 'ignore'))
		{
			$stream->next();
			$stream->expect(\Twig_Token::NAME_TYPE, 'missing');

			$ignoreMissing = true;
		}

		$stream->expect(\Twig_Token::BLOCK_END_TYPE);

		return new \src\template\twig\node\includephp($expr, $this->parser->getEnvironment(), $token->getLine(), $ignoreMissing, $this->getTag());
	}

	/**
	* Gets the tag name associated with this token parser.
	*
	* @return string The tag name
	*/
	public function getTag()
	{
		return 'INCLUDEPHP';
	}
}
