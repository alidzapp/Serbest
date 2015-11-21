<?php

namespace src\template\twig\tokenparser;

class defineparser extends \Twig_TokenParser
{
	/**
	* Parses a token and returns a node.
	*
	* @param \Twig_Token $token A Twig_Token instance
	*
	* @return \Twig_NodeInterface A Twig_NodeInterface instance
	* @throws \Twig_Error_Syntax
	* @throws \src\template\twig\node\definenode
	*/
	public function parse(\Twig_Token $token)
	{
		$lineno = $token->getLine();
		$stream = $this->parser->getStream();
		$name = $this->parser->getExpressionParser()->parseExpression();

		$capture = false;
		if ($stream->test(\Twig_Token::OPERATOR_TYPE, '='))
		{
			$stream->next();
			$value = $this->parser->getExpressionParser()->parseExpression();

			if ($value instanceof \Twig_Node_Expression_Name)
			{
				// This would happen if someone improperly formed their DEFINE syntax
				// e.g. <!-- DEFINE $VAR = foo -->
				throw new \Twig_Error_Syntax('Invalid DEFINE', $token->getLine(), $this->parser->getFilename());
			}

			$stream->expect(\Twig_Token::BLOCK_END_TYPE);
		}
		else
		{
			$capture = true;

			$stream->expect(\Twig_Token::BLOCK_END_TYPE);

			$value = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
			$stream->expect(\Twig_Token::BLOCK_END_TYPE);
		}

		return new \src\template\twig\node\definenode($capture, $name, $value, $lineno, $this->getTag());
	}

	public function decideBlockEnd(\Twig_Token $token)
	{
		return $token->test('ENDDEFINE');
	}

	/**
	* Gets the tag name associated with this token parser.
	*
	* @return string The tag name
	*/
	public function getTag()
	{
		return 'DEFINE';
	}
}
