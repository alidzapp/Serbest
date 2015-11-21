<?php


namespace src\controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

/**
* Controller helper class, contains methods that do things for controllers
*/
class helper
{
	/**
	* Template object
	* @var \src\template\template
	*/
	protected $template;

	/**
	* User object
	* @var \src\user
	*/
	protected $user;

	/**
	* config object
	* @var \src\config\config
	*/
	protected $config;

	/* @var \src\symfony_request */
	protected $symfony_request;

	/* @var \src\request\request_interface */
	protected $request;

	/**
	* @var \src\filesystem The filesystem object
	*/
	protected $filesystem;

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
	* Constructor
	*
	* @param \src\template\template $template Template object
	* @param \src\user $user User object
	* @param \src\config\config $config Config object
	* @param \src\controller\provider $provider Path provider
	* @param \src\extension\manager $manager Extension manager object
	* @param \src\symfony_request $symfony_request Symfony Request object
	* @param \src\request\request_interface $request src request object
	* @param \src\filesystem $filesystem The filesystem object
	* @param string $src_root_path src root path
	* @param string $php_ext PHP file extension
	*/
	public function __construct(\src\template\template $template, \src\user $user, \src\config\config $config, \src\controller\provider $provider, \src\extension\manager $manager, \src\symfony_request $symfony_request, \src\request\request_interface $request, \src\filesystem $filesystem, $src_root_path, $php_ext)
	{
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->symfony_request = $symfony_request;
		$this->request = $request;
		$this->filesystem = $filesystem;
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
		$provider->find_routing_files($manager->get_finder());
		$this->route_collection = $provider->find($src_root_path)->get_routes();
	}

	/**
	* Automate setting up the page and creating the response object.
	*
	* @param string $template_file The template handle to render
	* @param string $page_title The title of the page to output
	* @param int $status_code The status code to be sent to the page header
	* @param bool $display_online_list Do we display online users list
	*
	* @return Response object containing rendered page
	*/
	public function render($template_file, $page_title = '', $status_code = 200, $display_online_list = false)
	{
		page_header($page_title, $display_online_list);

		$this->template->set_filenames(array(
			'body'	=> $template_file,
		));

		page_footer(true, false, false);

		return new Response($this->template->assign_display('body'), $status_code);
	}

	/**
	* Generate a URL to a route
	*
	* @param string	$route		Name of the route to travel
	* @param array	$params		String or array of additional url parameters
	* @param bool	$is_amp		Is url using &amp; (true) or & (false)
	* @param string|bool		$session_id	Possibility to use a custom session id instead of the global one
	* @param bool|string		$reference_type The type of reference to be generated (one of the constants)
	* @return string The URL already passed through append_sid()
	*/
	public function route($route, array $params = array(), $is_amp = true, $session_id = false, $reference_type = UrlGeneratorInterface::ABSOLUTE_PATH)
	{
		$anchor = '';
		if (isset($params['#']))
		{
			$anchor = '#' . $params['#'];
			unset($params['#']);
		}

		$context = new RequestContext();
		$context->fromRequest($this->symfony_request);

		$script_name = $this->symfony_request->getScriptName();
		$page_name = substr($script_name, -1, 1) == '/' ? '' : utf8_basename($script_name);

		$base_url = $context->getBaseUrl();

		// Append page name if base URL does not contain it
		if (!empty($page_name) && strpos($base_url, '/' . $page_name) === false)
		{
			$base_url .= '/' . $page_name;
		}

		// If enable_mod_rewrite is false we need to replace the current front-end by app.php, otherwise we need to remove it.
		$base_url = str_replace('/' . $page_name, empty($this->config['enable_mod_rewrite']) ? '/app.' . $this->php_ext : '', $base_url);

		// We need to update the base url to move to the directory of the app.php file if the current script is not app.php
		if ($page_name !== 'app.php')
		{
			if (empty($this->config['enable_mod_rewrite']))
			{
				$base_url = str_replace('/app.' . $this->php_ext, '/' . $this->src_root_path . 'app.' . $this->php_ext, $base_url);
			}
			else
			{
				$base_url .= preg_replace(get_preg_expression('path_remove_dot_trailing_slash'), '$2', $this->src_root_path);
			}
		}

		$base_url = $this->request->escape($this->filesystem->clean_path($base_url), true);

		$context->setBaseUrl($base_url);

		$url_generator = new UrlGenerator($this->route_collection, $context);
		$route_url = $url_generator->generate($route, $params, $reference_type);

		if ($is_amp)
		{
			$route_url = str_replace(array('&amp;', '&'), array('&', '&amp;'), $route_url);
		}

		if ($reference_type === UrlGeneratorInterface::RELATIVE_PATH && empty($this->config['enable_mod_rewrite']))
		{
			$route_url = 'app.' . $this->php_ext . '/' . $route_url;
		}

		return append_sid($route_url . $anchor, false, $is_amp, $session_id, true);
	}

	/**
	* Output an error, effectively the same thing as trigger_error
	*
	* @param string $message The error message
	* @param int $code The error code (e.g. 404, 500, 503, etc.)
	* @return Response A Response instance
	*
	* @deprecated 3.1.3 (To be removed: 3.3.0) Use exceptions instead.
	*/
	public function error($message, $code = 500)
	{
		return $this->message($message, array(), 'INFORMATION', $code);
	}

	/**
	 * Output a message
	 *
	 * In case of an error, please throw an exception instead
	 *
	 * @param string $message The message to display (must be a language variable)
	 * @param array $parameters The parameters to use with the language var
	 * @param string $title Title for the message (must be a language variable)
	 * @param int $code The HTTP status code (e.g. 404, 500, 503, etc.)
	 * @return Response A Response instance
	 */
	public function message($message, array $parameters = array(), $title = 'INFORMATION', $code = 200)
	{
		array_unshift($parameters, $message);
		$message_text = call_user_func_array(array($this->user, 'lang'), $parameters);
		$message_title = $this->user->lang($title);

		if ($this->request->is_ajax())
		{
			global $refresh_data;

			return new JsonResponse(
				array(
					'MESSAGE_TITLE'		=> $message_title,
					'MESSAGE_TEXT'		=> $message_text,
					'S_USER_WARNING'	=> false,
					'S_USER_NOTICE'		=> false,
					'REFRESH_DATA'		=> (!empty($refresh_data)) ? $refresh_data : null
				),
				$code
			);
		}

		$this->template->assign_vars(array(
			'MESSAGE_TEXT'	=> $message_text,
			'MESSAGE_TITLE'	=> $message_title,
		));

		return $this->render('message_body.html', $message_title, $code);
	}

	/**
	* Return the current url
	*
	* @return string
	*/
	public function get_current_url()
	{
		return generate_srcrd_url(true) . $this->request->escape($this->symfony_request->getRequestUri(), true);
	}
}
