<?php

namespace design\designTCP\controller;

class main
{
  /* @var \src\auth\auth */
    protected $auth;

  /* @var \src\config\config */
  protected $config;

  /* @var \src\template\template */
  protected $template;

  /* @var \src\user */
  protected $user;

  /* @var \src\controller\helper */
  protected $helper;

  /* @var string src root path */
  protected $root_path;

  /* @var string phpEx */
  protected $php_ext;

  protected $settings;

  /**
  * Constructor
  * NOTE: The parameters of this method must match in order and type with
  * the dependencies defined in the services.yml file for this service.
  *
  * @param \src\auth\auth                          $auth       Auth object
  * @param \src\config                             $config     Config object
  * @param \src\template                           $template   Template object
  * @param \src\user                               $user       User object
  * @param \src\controller\helper                  $helper     Controller helper object
  * @param string                                    $root_path  src root path
  * @param string                                    $php_ext    phpEx
  * @param \design\designTCP\controller\settings  $settings   Settings object
  */
  public function __construct(\src\auth\auth $auth, \src\config\config $config, \src\template\template $template, \src\user $user, \src\controller\helper $helper, $root_path, $php_ext, \design\designTCP\controller\settings $settings)
  {
    $this->auth = $auth;
    $this->config = $config;
    $this->template = $template;
    $this->user = $user;
    $this->helper = $helper;
    $this->root_path = $root_path;
    $this->php_ext = $php_ext;
    $this->settings = $settings;
  }

  /**
  * Base controller to be accessed with the URL /mobbern-tcp
  *
  * @return Symfony\Component\HttpFoundation\Response A Symfony Response object
  */
  public function base()
  {
    // Redirect non admins back to the index page
    if (!$this->auth->acl_get('a_'))
    {
      return $this->settings->finish('MBRN_INVALID_LOGIN', 400, 4, 'm_Mobbern_home');
    }

    // Form key validation
    $this->m_tcp_settings();


    /**
    * The render method takes up to three other arguments
    * @param   string      Name of the template file to display
    *                      Template files are searched for two places:
    *                      - src/styles/<style_name>/template/
    *                      - src/ext/<all_active_extensions>/styles/<style_name>/template/
    * @param   string      Page title
    * @param   int         Status code of the page (200 - OK [ default ], 403 - Unauthorized, 404 - Page not found, etc.)
    */
    return $this->helper->render('m_tcp.html', 'Theme Control Panel');
  }

  protected function m_tcp_settings()
  {
     add_form_key('m_tcp_settings');
  }
}