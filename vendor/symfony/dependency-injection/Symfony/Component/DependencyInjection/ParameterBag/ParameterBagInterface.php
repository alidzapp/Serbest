<?php


namespace Symfony\Component\DependencyInjection\ParameterBag;

use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

interface ParameterBagInterface
{
    /**
     * Clears all parameters.
     *
     * @api
     */
    public function clear();

    /**
     * Adds parameters to the service container parameters.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
    public function add(array $parameters);

    /**
     * Gets the service container parameters.
     *
     * @return array An array of parameters
     *
     * @api
     */
    public function all();

    /**
     * Gets a service container parameter.
     *
     * @param string $name The parameter name
     *
     * @return mixed  The parameter value
     *
     * @throws ParameterNotFoundException if the parameter is not defined
     *
     * @api
     */
    public function get($name);

    /**
     * Sets a service container parameter.
     *
     * @param string $name  The parameter name
     * @param mixed  $value The parameter value
     *
     * @api
     */
    public function set($name, $value);

    /**
     * Returns true if a parameter name is defined.
     *
     * @param string $name The parameter name
     *
     * @return bool    true if the parameter name is defined, false otherwise
     *
     * @api
     */
    public function has($name);

    /**
     * Replaces parameter placeholders (%name%) by their values for all parameters.
     */
    public function resolve();

    /**
     * Replaces parameter placeholders (%name%) by their values.
     *
     * @param mixed $value A value
     *
     * @throws ParameterNotFoundException if a placeholder references a parameter that does not exist
     */
    public function resolveValue($value);

    /**
     * Escape parameter placeholders %
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function escapeValue($value);

    /**
     * Unescape parameter placeholders %
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function unescapeValue($value);
}
