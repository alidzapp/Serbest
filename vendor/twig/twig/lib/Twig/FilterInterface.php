<?php


interface Twig_FilterInterface
{
    /**
     * Compiles a filter.
     *
     * @return string The PHP code for the filter
     */
    public function compile();

    public function needsEnvironment();

    public function needsContext();

    public function getSafe(Twig_Node $filterArgs);

    public function getPreservesSafety();

    public function getPreEscape();

    public function setArguments($arguments);

    public function getArguments();
}
