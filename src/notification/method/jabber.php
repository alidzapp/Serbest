<?php


namespace src\notification\method;

/**
* Jabber notification method class
* This class handles sending Jabber messages for notifications
*/

class jabber extends \src\notification\method\messenger_base
{
	/**
	* Get notification method name
	*
	* @return string
	*/
	public function get_type()
	{
		return 'notification.method.jabber';
	}

	/**
	* Is this method available for the user?
	* This is checked on the notifications options
	*/
	public function is_available()
	{
		return ($this->global_available() && $this->user->data['user_jabber']);
	}

	/**
	* Is this method available at all?
	* This is checked before notifications are sent
	*/
	public function global_available()
	{
		return !(
			empty($this->config['jab_enable']) ||
			empty($this->config['jab_host']) ||
			empty($this->config['jab_username']) ||
			empty($this->config['jab_password']) ||
			!@extension_loaded('xml')
		);
	}

	public function notify()
	{
		if (!$this->global_available())
		{
			return;
		}

		return $this->notify_using_messenger(NOTIFY_IM, 'short/');
	}
}
