<?php


interface Twig_TokenParserBrokerInterface
{
    /**
     * Gets a TokenParser suitable for a tag.
     *
     * @param string $tag A tag name
     *
     * @return null|Twig_TokenParserInterface A Twig_TokenParserInterface or null if no suitable TokenParser was found
     */
    public function getTokenParser($tag);

    /**
     * Calls Twig_TokenParserInterface::setParser on all parsers the implementation knows of.
     *
     * @param Twig_ParserInterface $parser A Twig_ParserInterface interface
     */
    public function setParser(Twig_ParserInterface $parser);

    /**
     * Gets the Twig_ParserInterface.
     *
     * @return null|Twig_ParserInterface A Twig_ParserInterface instance or null
     */
    public function getParser();
}
