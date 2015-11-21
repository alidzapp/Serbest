<?php

namespace src\notification\method;

/**
* Base notifications method class
*/
abstract class base implements \src\notification\method\method_interface
{
	/** @var \src\notification\manager */
	protected $notification_manager;

	/** @var \src\user_loader */
	protected $user_loader;

	/** @var \src\db\driver\driver_interface */
	protected $db;

	/** @var \src\cache\driver\driver_interface */
	protected $cache;

	/** @var \src\template\template */
	protected $template;

	/** @var \src\extension\manager */
	protected $extension_manager;

	/** @var \src\user */
	protected $user;

	/** @var \src\auth\auth */
	protected $auth;

	/** @var \src\config\config */
	protected $config;

	/** @var string */
	protected $src_root_path;

	/** @var string */
	protected $php_ext;

	/**
	* Queue of messages to be sent
	*
	* @var array
	*/
	protected $queue = array();

	/**
	* Notification Method Base Constructor
	*
	* @param \src\user_loader $user_loader
	* @param \src\db\driver\driver_interface $db
	* @param \src\cache\driver\driver_interface $cache
	* @param \src\user $user
	* @param \src\auth\auth $auth
	* @param \src\config\config $config
	* @param string $src_root_path
	* @param string $php_ext
	* @return \src\notification\method\base
	*/
	public function __construct(\src\user_loader $user_loader, \src\db\driver\driver_interface $db, \src\cache\driver\driver_interface $cache, $user, \src\auth\auth $auth, \src\config\config $config, $src_root_path, $php_ext)
	{
		$this->user_loader = $user_loader;
		$this->db = $db;
		$this->cache = $cache;
		$this->user = $user;
		$this->auth = $auth;
		$this->config = $config;
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Set notification manager (required)
	*
	* @param \src\notification\manager $notification_manager
	*/
	public function set_notification_manager(\src\notification\manager $notification_manager)
	{
		$this->notification_manager = $notification_manager;
	}

	/**
	* Add a notification to the queue
	*
	* @param \src\notification\type\type_interface $notification
	*/
	public function add_to_queue(\src\notification\type\type_interface $notification)
	{
		$this->queue[] = $notification;
	}

	/**
	* Empty the queue
	*/
	protected function empty_queue()
	{
		$this->queue = array();
	}
}
