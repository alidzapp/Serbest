<?php

namespace src\feed;

/**
* Class with some helpful functions used in feeds
*/
class helper
{
	/** @var \src\config\config */
	protected $config;

	/** @var \src\user */
	protected $user;

	/** @var string */
	protected $src_root_path;

	/** @var string */
	protected $phpEx;

	/**
	* Constructor
	*
	* @param	\src\config\config	$config		Config object
	* @param	\src\user		$user		User object
	* @param	string	$src_root_path	Root path
	* @param	string	$phpEx				PHP file extension
	*/
	public function __construct(\src\config\config $config, \src\user $user, $src_root_path, $phpEx)
	{
		$this->config = $config;
		$this->user = $user;
		$this->src_root_path = $src_root_path;
		$this->phpEx = $phpEx;
	}

	/**
	* Run links through append_sid(), prepend generate_srcrd_url() and remove session id
	*/
	public function get_srcrd_url()
	{
		static $srcrd_url;

		if (empty($srcrd_url))
		{
			$srcrd_url = generate_srcrd_url();
		}

		return $srcrd_url;
	}

	/**
	* Run links through append_sid(), prepend generate_srcrd_url() and remove session id
	*/
	public function append_sid($url, $params)
	{
		return append_sid($this->get_srcrd_url() . '/' . $url, $params, true, '');
	}

	/**
	* Generate ISO 8601 date string (RFC 3339)
	*/
	public function format_date($time)
	{
		static $zone_offset;
		static $offset_string;

		if (empty($offset_string))
		{
			$zone_offset = $this->user->create_datetime()->getOffset();
			$offset_string = src_format_timezone_offset($zone_offset);
		}

		return gmdate("Y-m-d\TH:i:s", $time + $zone_offset) . $offset_string;
	}

	/**
	* Generate text content
	*
	* @param string $content is feed text content
	* @param string $uid is bbcode_uid
	* @param string $bitfield is bbcode bitfield
	* @param int $options bbcode flag options
	* @param int $forum_id is the forum id
	* @param array $post_attachments is an array containing the attachments and their respective info
	* @return string the html content to be printed for the feed
	*/
	public function generate_content($content, $uid, $bitfield, $options, $forum_id, $post_attachments)
	{
		if (empty($content))
		{
			return '';
		}

		// Prepare some bbcodes for better parsing
		$content	= preg_replace("#\[quote(=&quot;.*?&quot;)?:$uid\]\s*(.*?)\s*\[/quote:$uid\]#si", "[quote$1:$uid]<br />$2<br />[/quote:$uid]", $content);

		$content = generate_text_for_display($content, $uid, $bitfield, $options);

		// Add newlines
		$content = str_replace('<br />', '<br />' . "\n", $content);

		// Convert smiley Relative paths to Absolute path, Windows style
		$content = str_replace($this->src_root_path . $this->config['smilies_path'], $this->get_srcrd_url() . '/' . $this->config['smilies_path'], $content);

		// Remove "Select all" link and mouse events
		$content = str_replace('<a href="#" onclick="selectCode(this); return false;">' . $this->user->lang['SELECT_ALL_CODE'] . '</a>', '', $content);
		$content = preg_replace('#(onkeypress|onclick)="(.*?)"#si', '', $content);

		// Firefox does not support CSS for feeds, though

		// Remove font sizes
	//	$content = preg_replace('#<span style="font-size: [0-9]+%; line-height: [0-9]+%;">([^>]+)</span>#iU', '\1', $content);

		// Make text strong :P
	//	$content = preg_replace('#<span style="font-weight: bold?">(.*?)</span>#iU', '<strong>\1</strong>', $content);

		// Italic
	//	$content = preg_replace('#<span style="font-style: italic?">([^<]+)</span>#iU', '<em>\1</em>', $content);

		// Underline
	//	$content = preg_replace('#<span style="text-decoration: underline?">([^<]+)</span>#iU', '<u>\1</u>', $content);

		// Remove embed Windows Media Streams
		$content	= preg_replace( '#<\!--\[if \!IE\]>-->([^[]+)<\!--<!\[endif\]-->#si', '', $content);

		// Do not use &lt; and &gt;, because we want to retain code contained in [code][/code]

		// Remove embed and objects
		$content	= preg_replace( '#<(object|embed)(.*?) (value|src)=(.*?) ([^[]+)(object|embed)>#si',' <a href=$4 target="_blank"><strong>$1</strong></a> ',$content);

		// Remove some specials html tag, because somewhere there are a mod to allow html tags ;)
		$content	= preg_replace( '#<(script|iframe)([^[]+)\1>#siU', ' <strong>$1</strong> ', $content);

		// Parse inline images to display with the feed
		if (!empty($post_attachments))
		{
			$update_count = array();
			parse_attachments($forum_id, $content, $post_attachments, $update_count);
			$post_attachments = implode('<br />', $post_attachments);

			// Convert attachments' relative path to absolute path
			$post_attachments = str_replace($this->src_root_path . 'download/file.' . $this->phpEx, $this->get_srcrd_url() . '/download/file.' . $this->phpEx, $post_attachments);

			$content .= $post_attachments;
		}

		// Remove Comments from inline attachments [ia]
		$content = preg_replace('#<dd>(.*?)</dd>#','',$content);

		// Replace some entities with their unicode counterpart
		$entities = array(
			'&nbsp;'	=> "\xC2\xA0",
			'&bull;'	=> "\xE2\x80\xA2",
			'&middot;'	=> "\xC2\xB7",
			'&copy;'	=> "\xC2\xA9",
		);

		$content = str_replace(array_keys($entities), array_values($entities), $content);

		// Remove CDATA blocks. ;)
		$content = preg_replace('#\<\!\[CDATA\[(.*?)\]\]\>#s', '', $content);

		// Other control characters
		$content = preg_replace('#(?:[\x00-\x1F\x7F]+|(?:\xC2[\x80-\x9F])+)#', '', $content);

		return $content;
	}
}
