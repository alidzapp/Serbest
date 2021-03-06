<?php


namespace src\template\twig\tokenparser;

class php extends \Twig_TokenParser
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
		$stream = $this->parser->getStream();

		$stream->expect(\Twig_Token::BLOCK_END_TYPE);

		$body = $this->parser->subparse(array($this, 'decideEnd'), true);

		$stream->expect(\Twig_Token::BLOCK_END_TYPE);

		return new \src\template\twig\node\php($body, $this->parser->getEnvironment(), $token->getLine(), $this->getTag());
	}

	public function decideEnd(\Twig_Token $token)
	{
		return $token->test('ENDPHP');
	}

	/**
	* Gets the tag name associated with this token parser.
	*
	* @return string The tag name
	*/
	public function getTag()
	{
		return 'PHP';
	}
}
