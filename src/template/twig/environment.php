<?php


namespace src\template\twig;

class environment extends \Twig_Environment
{
	/** @var \src\config\config */
	protected $src_config;

	/** @var \src\path_helper */
	protected $src_path_helper;

	/** @var \src\extension\manager */
	protected $extension_manager;

	/** @var string */
	protected $src_root_path;

	/** @var string */
	protected $web_root_path;

	/** @var array **/
	protected $namespace_look_up_order = array('__main__');

	/**
	* Constructor
	*
	* @param \src\config\config $src_config The src configuration
	* @param \src\path_helper $path_helper src path helper
	* @param \src\extension\manager $extension_manager src extension manager
	* @param \Twig_LoaderInterface $loader Twig loader interface
	* @param array $options Array of options to pass to Twig
	*/
	public function __construct($src_config, \src\path_helper $path_helper, \src\extension\manager $extension_manager = null, \Twig_LoaderInterface $loader = null, $options = array())
	{
		$this->src_config = $src_config;

		$this->src_path_helper = $path_helper;
		$this->extension_manager = $extension_manager;

		$this->src_root_path = $this->src_path_helper->get_src_root_path();
		$this->web_root_path = $this->src_path_helper->get_web_root_path();

		return parent::__construct($loader, $options);
	}

	/**
	* Get the list of enabled src extensions
	*
	* Used in EVENT node
	*
	* @return array
	*/
	public function get_src_extensions()
	{
		return ($this->extension_manager) ? $this->extension_manager->all_enabled() : array();
	}

	/**
	* Get src config
	*
	* @return \src\config\config
	*/
	public function get_src_config()
	{
		return $this->src_config;
	}

	/**
	* Get the src root path
	*
	* @return string
	*/
	public function get_src_root_path()
	{
		return $this->src_root_path;
	}

	/**
	* Get the web root path
	*
	* @return string
	*/
	public function get_web_root_path()
	{
		return $this->web_root_path;
	}

	/**
	* Get the src path helper object
	*
	* @return \src\path_helper
	*/
	public function get_path_helper()
	{
		return $this->src_path_helper;
	}

	/**
	* Get the namespace look up order
	*
	* @return array
	*/
	public function getNamespaceLookUpOrder()
	{
		return $this->namespace_look_up_order;
	}

	/**
	* Set the namespace look up order to load templates from
	*
	* @param array $namespace
	* @return \Twig_Environment
	*/
	public function setNamespaceLookUpOrder($namespace)
	{
		$this->namespace_look_up_order = $namespace;

		return $this;
	}

	/**
	* Loads a template by name.
	*
	* @param string  $name  The template name
	* @param integer $index The index if it is an embedded template
	* @return \Twig_TemplateInterface A template instance representing the given template name
	* @throws \Twig_Error_Loader
	*/
	public function loadTemplate($name, $index = null)
	{
		if (strpos($name, '@') === false)
		{
			foreach ($this->getNamespaceLookUpOrder() as $namespace)
			{
				try
				{
					if ($namespace === '__main__')
					{
						return parent::loadTemplate($name, $index);
					}

					return parent::loadTemplate('@' . $namespace . '/' . $name, $index);
				}
				catch (\Twig_Error_Loader $e)
				{
				}
			}

			// We were unable to load any templates
			throw $e;
		}
		else
		{
			return parent::loadTemplate($name, $index);
		}
	}

	/**
	* Finds a template by name.
	*
	* @param string  $name  The template name
	* @return string
	* @throws \Twig_Error_Loader
	*/
	public function findTemplate($name)
	{
		if (strpos($name, '@') === false)
		{
			foreach ($this->getNamespaceLookUpOrder() as $namespace)
			{
				try
				{
					if ($namespace === '__main__')
					{
						return parent::getLoader()->getCacheKey($name);
					}

					return parent::getLoader()->getCacheKey('@' . $namespace . '/' . $name);
				}
				catch (\Twig_Error_Loader $e)
				{
				}
			}

			// We were unable to load any templates
			throw $e;
		}
		else
		{
			return parent::getLoader()->getCacheKey($name);
		}
	}
}
