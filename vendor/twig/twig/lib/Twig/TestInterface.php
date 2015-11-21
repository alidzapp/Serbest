<?php


interface Twig_TestInterface
{
    /**
     * Compiles a test.
     *
     * @return string The PHP code for the test
     */
    public function compile();
}
