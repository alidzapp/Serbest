<?php


namespace src\message;

/**
* Class admin_form
* Displays a message to the user and allows him to send an email
*/
class admin_form extends form
{
	/** @var \src\config\db_text */
	protected $config_text;

	/** @var string */
	protected $subject;
	/** @var string */
	protected $sender_name;
	/** @var string */
	protected $sender_address;

	/**
	* Construct
	*
	* @param \src\auth\auth $auth
	* @param \src\config\config $config
	* @param \src\config\db_text $config_text
	* @param \src\db\driver\driver_interface $db
	* @param \src\user $user
	* @param string $src_root_path
	* @param string $phpEx
	*/
	public function __construct(\src\auth\auth $auth, \src\config\config $config, \src\config\db_text $config_text, \src\db\driver\driver_interface $db, \src\user $user, $src_root_path, $phpEx)
	{
		parent::__construct($auth, $config, $db, $user, $src_root_path, $phpEx);
		$this->config_text = $config_text;
	}

	/**
	* {inheritDoc}
	*/
	public function check_allow()
	{
		$error = parent::check_allow();
		if ($error)
		{
			return $error;
		}

		if (!$this->config['contact_admin_form_enable'])
		{
			return 'NO_CONTACT_PAGE';
		}

		return false;
	}

	/**
	* {inheritDoc}
	*/
	public function bind(\src\request\request_interface $request)
	{
		parent::bind($request);

		$this->subject = $request->variable('subject', '', true);
		$this->sender_address = $request->variable('email', '');
		$this->sender_name = $request->variable('name', '', true);
	}

	/**
	* {inheritDoc}
	*/
	public function submit(\messenger $messenger)
	{
		if (!$this->subject)
		{
			$this->errors[] = $this->user->lang['EMPTY_SUBJECT_EMAIL'];
		}
		if (!$this->body)
		{
			$this->errors[] = $this->user->lang['EMPTY_MESSAGE_EMAIL'];
		}

		if ($this->user->data['is_registered'])
		{
			$this->message->set_sender_from_user($this->user);
			$this->sender_name = $this->user->data['username'];
			$this->sender_address = $this->user->data['user_email'];
		}
		else
		{
			if (!$this->sender_name)
			{
				$this->errors[] = $this->user->lang['EMPTY_SENDER_NAME'];
			}

			if (!function_exists('validate_data'))
			{
				require($this->src_root_path . 'includes/functions_user.' . $this->phpEx);
			}

			$validate_array = validate_data(
				array(
					'email' => $this->sender_address,
				),
				array(
					'email' => array(
						array('string', false, 6, 60),
						array('email'),
					),
				)
			);

			foreach ($validate_array as $error)
			{
				$this->errors[] = $this->user->lang[$error];
			}

			$this->message->set_sender($this->user->ip, $this->sender_name, $this->sender_address, $this->user->lang_name);
			$this->message->set_sender_notify_type(NOTIFY_EMAIL);
		}

		$this->message->set_template('contact_admin');
		$this->message->set_subject($this->subject);
		$this->message->set_body($this->body);
		$this->message->add_recipient(
			$this->user->lang['ADMINISTRATOR'],
			$this->config['srcrd_contact'],
			$this->config['default_lang'],
			NOTIFY_EMAIL
		);

		$this->message->set_template_vars(array(
			'FROM_EMAIL_ADDRESS'	=> $this->sender_address,
			'FROM_IP_ADDRESS'		=> $this->user->ip,
			'S_IS_REGISTERED'		=> $this->user->data['is_registered'],

			'U_FROM_PROFILE'		=> generate_srcrd_url() . '/memberlist.' . $this->phpEx . '?mode=viewprofile&u=' . $this->user->data['user_id'],
		));

		parent::submit($messenger);
	}

	/**
	* {inheritDoc}
	*/
	public function render(\src\template\template $template)
	{
		$l_admin_info = $this->config_text->get('contact_admin_info');
		if ($l_admin_info)
		{
			$contact_admin_data			= $this->config_text->get_array(array(
				'contact_admin_info',
				'contact_admin_info_uid',
				'contact_admin_info_bitfield',
				'contact_admin_info_flags',
			));

			$l_admin_info = generate_text_for_display(
				$contact_admin_data['contact_admin_info'],
				$contact_admin_data['contact_admin_info_uid'],
				$contact_admin_data['contact_admin_info_bitfield'],
				$contact_admin_data['contact_admin_info_flags']
			);
		}

		$template->assign_vars(array(
			'S_CONTACT_ADMIN'	=> true,
			'S_CONTACT_FORM'	=> $this->config['contact_admin_form_enable'],
			'S_IS_REGISTERED'	=> $this->user->data['is_registered'],
			'S_POST_ACTION'		=> append_sid($this->src_root_path . 'memberlist.' . $this->phpEx, 'mode=contactadmin'),

			'CONTACT_INFO'		=> $l_admin_info,
			'MESSAGE'			=> $this->body,
			'SUBJECT'			=> $this->subject,
			'NAME'				=> $this->sender_name,
			'EMAIL'				=> $this->sender_address,
		));

		parent::render($template);
	}
}
