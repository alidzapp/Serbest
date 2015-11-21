<?php


namespace src\template\twig;

/**
* Twig Template class.
*/
class twig extends \src\template\base
{
	/**
	* Path of the cache directory for the template
	*
	* Cannot be changed during runtime.
	*
	* @var string
	*/
	private $cachepath = '';

	/**
	* src path helper
	* @var \src\path_helper
	*/
	protected $path_helper;

	/**
	* src root path
	* @var string
	*/
	protected $src_root_path;

	/**
	* PHP file extension
	* @var string
	*/
	protected $php_ext;

	/**
	* src config instance
	* @var \src\config\config
	*/
	protected $config;

	/**
	* Current user
	* @var \src\user
	*/
	protected $user;

	/**
	* Extension manager.
	*
	* @var \src\extension\manager
	*/
	protected $extension_manager;

	/**
	* Twig Environment
	*
	* @var \Twig_Environment
	*/
	protected $twig;

	/**
	* Constructor.
	*
	* @param \src\path_helper $path_helper
	* @param \src\config\config $config
	* @param \src\user $user
	* @param \src\template\context $context template context
	* @param \src\extension\manager $extension_manager extension manager, if null then template events will not be invoked
	*/
	public function __construct(\src\path_helper $path_helper, $config, $user, \src\template\context $context, \src\extension\manager $extension_manager = null)
	{
		$this->path_helper = $path_helper;
		$this->src_root_path = $path_helper->get_src_root_path();
		$this->php_ext = $path_helper->get_php_ext();
		$this->config = $config;
		$this->user = $user;
		$this->context = $context;
		$this->extension_manager = $extension_manager;

		$this->cachepath = $this->src_root_path . 'cache/twig/';

		// Initiate the loader, __main__ namespace paths will be setup later in set_style_names()
		$loader = new \src\template\twig\loader('');

		$this->twig = new \src\template\twig\environment(
			$this->config,
			$this->path_helper,
			$this->extension_manager,
			$loader,
			array(
				'cache'			=> (defined('IN_INSTALL')) ? false : $this->cachepath,
				'debug'			=> defined('DEBUG'),
				'auto_reload'	=> (bool) $this->config['load_tplcompile'],
				'autoescape'	=> false,
			)
		);

		$this->twig->addExtension(
			new \src\template\twig\extension(
				$this->context,
				$this->user
			)
		);

		if (defined('DEBUG'))
		{
			$this->twig->addExtension(new \Twig_Extension_Debug());
		}

		$lexer = new \src\template\twig\lexer($this->twig);

		$this->twig->setLexer($lexer);

		// Add admin namespace
		if ($this->path_helper->get_adm_relative_path() !== null && is_dir($this->src_root_path . $this->path_helper->get_adm_relative_path() . 'style/'))
		{
			$this->twig->getLoader()->setPaths($this->src_root_path . $this->path_helper->get_adm_relative_path() . 'style/', 'admin');
		}
	}

	/**
	* Clear the cache
	*
	* @return \src\template\template
	*/
	public function clear_cache()
	{
		if (is_dir($this->cachepath))
		{
			$this->twig->clearCacheFiles();
		}

		return $this;
	}

	/**
	* Get the style tree of the style preferred by the current user
	*
	* @return array Style tree, most specific first
	*/
	public function get_user_style()
	{
		$style_list = array(
			$this->user->style['style_path'],
		);

		if ($this->user->style['style_parent_id'])
		{
			$style_list = array_merge($style_list, array_reverse(explode('/', $this->user->style['style_parent_tree'])));
		}

		return $style_list;
	}

	/**
	* Set style location based on (current) user's chosen style.
	*
	* @param array $style_directories The directories to add style paths for
	* 	E.g. array('ext/foo/bar/styles', 'styles')
	* 	Default: array('styles') (src's style directory)
	* @return \src\template\template $this
	*/
	public function set_style($style_directories = array('styles'))
	{
		if ($style_directories !== array('styles') && $this->twig->getLoader()->getPaths('core') === array())
		{
			// We should set up the core styles path since not already setup
			$this->set_style();
		}

		$names = $this->get_user_style();
		// Add 'all' folder to $names array
		//	It allows extensions to load a template file from 'all' folder,
		//	if a style doesn't include it.
		$names[] = 'all';

		$paths = array();
		foreach ($style_directories as $directory)
		{
			foreach ($names as $name)
			{
				$path = $this->src_root_path . trim($directory, '/') . "/{$name}/";
				$template_path = $path . 'template/';
				$theme_path = $path . 'theme/';

				$is_valid_dir = false;
				if (is_dir($template_path))
				{
					$is_valid_dir = true;
					$paths[] = $template_path;
				}
				if (is_dir($theme_path))
				{
					$is_valid_dir = true;
					$paths[] = $theme_path;
				}

				if ($is_valid_dir)
				{
					// Add the base style directory as a safe directory
					$this->twig->getLoader()->addSafeDirectory($path);
				}
			}
		}

		// If we're setting up the main src styles directory and the core
		// namespace isn't setup yet, we will set it up now
		if ($style_directories === array('styles') && $this->twig->getLoader()->getPaths('core') === array())
		{
			// Set up the core style paths namespace
			$this->twig->getLoader()->setPaths($paths, 'core');
		}

		$this->set_custom_style($names, $paths);

		return $this;
	}

	/**
	* Set custom style location (able to use directory outside of src).
	*
	* Note: Templates are still compiled to src's cache directory.
	*
	* @param string|array $names Array of names (or detailed names) or string of name of template(s) in inheritance tree order, used by extensions.
	*	E.g. array(
	*			'name' 		=> 'adm',
	*			'ext_path' 	=> 'adm/style/',
	*		)
	* @param string|array of string $paths Array of style paths, relative to current root directory
	* @return \src\template\template $this
	*/
	public function set_custom_style($names, $paths)
	{
		$paths = (is_string($paths)) ? array($paths) : $paths;
		$names = (is_string($names)) ? array($names) : $names;

		// Set as __main__ namespace
		$this->twig->getLoader()->setPaths($paths);

		// Add all namespaces for all extensions
		if ($this->extension_manager instanceof \src\extension\manager)
		{
			$names[] = 'all';

			foreach ($this->extension_manager->all_enabled() as $ext_namespace => $ext_path)
			{
				// namespaces cannot contain /
				$namespace = str_replace('/', '_', $ext_namespace);
				$paths = array();

				foreach ($names as $template_dir)
				{
					if (is_array($template_dir))
					{
						if (isset($template_dir['ext_path']))
						{
							$ext_style_template_path = $ext_path . $template_dir['ext_path'];
							$ext_style_path = dirname($ext_style_template_path);
							$ext_style_theme_path = $ext_style_path . 'theme/';
						}
						else
						{
							$ext_style_path = $ext_path . 'styles/' . $template_dir['name'] . '/';
							$ext_style_template_path = $ext_style_path . 'template/';
							$ext_style_theme_path = $ext_style_path . 'theme/';
						}
					}
					else
					{
						$ext_style_path = $ext_path . 'styles/' . $template_dir . '/';
						$ext_style_template_path = $ext_style_path . 'template/';
						$ext_style_theme_path = $ext_style_path . 'theme/';
					}

					$is_valid_dir = false;
					if (is_dir($ext_style_template_path))
					{
						$is_valid_dir = true;
						$paths[] = $ext_style_template_path;
					}
					if (is_dir($ext_style_theme_path))
					{
						$is_valid_dir = true;
						$paths[] = $ext_style_theme_path;
					}

					if ($is_valid_dir)
					{
						// Add the base style directory as a safe directory
						$this->twig->getLoader()->addSafeDirectory($ext_style_path);
					}
				}

				$this->twig->getLoader()->setPaths($paths, $namespace);
			}
		}

		return $this;
	}

	/**
	* Display a template for provided handle.
	*
	* The template will be loaded and compiled, if necessary, first.
	*
	* This function calls hooks.
	*
	* @param string $handle Handle to display
	* @return \src\template\template $this
	*/
	public function display($handle)
	{
		$result = $this->call_hook($handle, __FUNCTION__);
		if ($result !== false)
		{
			return $result[0];
		}

		$this->twig->display($this->get_filename_from_handle($handle), $this->get_template_vars());

		return $this;
	}

	/**
	* Display the handle and assign the output to a template variable
	* or return the compiled result.
	*
	* @param string $handle Handle to operate on
	* @param string $template_var Template variable to assign compiled handle to
	* @param bool $return_content If true return compiled handle, otherwise assign to $template_var
	* @return \src\template\template|string if $return_content is true return string of the compiled handle, otherwise return $this
	*/
	public function assign_display($handle, $template_var = '', $return_content = true)
	{
		if ($return_content)
		{
			return $this->twig->render($this->get_filename_from_handle($handle), $this->get_template_vars());
		}

		$this->assign_var($template_var, $this->twig->render($this->get_filename_from_handle($handle, $this->get_template_vars())));

		return $this;
	}

	/**
	* Get template vars in a format Twig will use (from the context)
	*
	* @return array
	*/
	protected function get_template_vars()
	{
		$context_vars = $this->context->get_data_ref();

		$vars = array_merge(
			$context_vars['.'][0], // To get normal vars
			array(
				'definition'	=> new \src\template\twig\definition(),
				'user'			=> $this->user,
				'loops'			=> $context_vars, // To get loops
			)
		);

		// cleanup
		unset($vars['loops']['.']);

		return $vars;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_source_file_for_handle($handle)
	{
		return $this->twig->getLoader()->getCacheKey($this->get_filename_from_handle($handle));
	}
}
