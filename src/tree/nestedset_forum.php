<?php


namespace src\tree;

class nestedset_forum extends \src\tree\nestedset
{
	/**
	* Construct
	*
	* @param \src\db\driver\driver_interface	$db		Database connection
	* @param \src\lock\db		$lock	Lock class used to lock the table when moving forums around
	* @param string				$table_name		Table name
	*/
	public function __construct(\src\db\driver\driver_interface $db, \src\lock\db $lock, $table_name)
	{
		parent::__construct(
			$db,
			$lock,
			$table_name,
			'FORUM_NESTEDSET_',
			'',
			array(
				'forum_id',
				'forum_name',
				'forum_type',
			),
			array(
				'item_id'		=> 'forum_id',
				'item_parents'	=> 'forum_parents',
			)
		);
	}
}
