<?php

namespace src\db\migration;

/**
* The schema generator generates the schema based on the existing migrations
*/
class schema_generator
{
	/** @var \src\config\config */
	protected $config;

	/** @var \src\db\driver\driver_interface */
	protected $db;

	/** @var \src\db\tools */
	protected $db_tools;

	/** @var array */
	protected $class_names;

	/** @var string */
	protected $table_prefix;

	/** @var string */
	protected $src_root_path;

	/** @var string */
	protected $php_ext;

	/** @var array */
	protected $tables;

	/** @var array */
	protected $dependencies = array();

	/**
	* Constructor
	*/
	public function __construct(array $class_names, \src\config\config $config, \src\db\driver\driver_interface $db, \src\db\tools $db_tools, $src_root_path, $php_ext, $table_prefix)
	{
		$this->config = $config;
		$this->db = $db;
		$this->db_tools = $db_tools;
		$this->class_names = $class_names;
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
		$this->table_prefix = $table_prefix;
	}

	/**
	* Loads all migrations and their application state from the database.
	*
	* @return array
	*/
	public function get_schema()
	{
		if (!empty($this->tables))
		{
			return $this->tables;
		}

		$migrations = $this->class_names;

		$tree = array();
		$check_dependencies = true;
		while (!empty($migrations))
		{
			foreach ($migrations as $migration_class)
			{
				$open_dependencies = array_diff($migration_class::depends_on(), $tree);

				if (empty($open_dependencies))
				{
					$migration = new $migration_class($this->config, $this->db, $this->db_tools, $this->src_root_path, $this->php_ext, $this->table_prefix);
					$tree[] = $migration_class;
					$migration_key = array_search($migration_class, $migrations);

					foreach ($migration->update_schema() as $change_type => $data)
					{
						if ($change_type === 'add_tables')
						{
							foreach ($data as $table => $table_data)
							{
								$this->tables[$table] = $table_data;
							}
						}
						else if ($change_type === 'drop_tables')
						{
							foreach ($data as $table)
							{
								unset($this->tables[$table]);
							}
						}
						else if ($change_type === 'add_columns')
						{
							foreach ($data as $table => $add_columns)
							{
								foreach ($add_columns as $column => $column_data)
								{
									if (isset($column_data['after']))
									{
										$columns = $this->tables[$table]['COLUMNS'];
										$offset = array_search($column_data['after'], array_keys($columns));
										unset($column_data['after']);

										if ($offset === false)
										{
											$this->tables[$table]['COLUMNS'][$column] = array_values($column_data);
										}
										else
										{
											$this->tables[$table]['COLUMNS'] = array_merge(array_slice($columns, 0, $offset + 1, true), array($column => array_values($column_data)), array_slice($columns, $offset));
										}
									}
									else
									{
										$this->tables[$table]['COLUMNS'][$column] = $column_data;
									}
								}
							}
						}
						else if ($change_type === 'change_columns')
						{
							foreach ($data as $table => $change_columns)
							{
								foreach ($change_columns as $column => $column_data)
								{
									$this->tables[$table]['COLUMNS'][$column] = $column_data;
								}
							}
						}
						else if ($change_type === 'drop_columns')
						{
							foreach ($data as $table => $drop_columns)
							{
								if (is_array($drop_columns))
								{
									foreach ($drop_columns as $column)
									{
										unset($this->tables[$table]['COLUMNS'][$column]);
									}
								}
								else
								{
									unset($this->tables[$table]['COLUMNS'][$drop_columns]);
								}
							}
						}
						else if ($change_type === 'add_unique_index')
						{
							foreach ($data as $table => $add_index)
							{
								foreach ($add_index as $key => $index_data)
								{
									$this->tables[$table]['KEYS'][$key] = array('UNIQUE', $index_data);
								}
							}
						}
						else if ($change_type === 'add_index')
						{
							foreach ($data as $table => $add_index)
							{
								foreach ($add_index as $key => $index_data)
								{
									$this->tables[$table]['KEYS'][$key] = array('INDEX', $index_data);
								}
							}
						}
						else if ($change_type === 'drop_keys')
						{
							foreach ($data as $table => $drop_keys)
							{
								foreach ($drop_keys as $key)
								{
									unset($this->tables[$table]['KEYS'][$key]);
								}
							}
						}
						else
						{
							var_dump($change_type);
						}
					}
					unset($migrations[$migration_key]);
				}
				else if ($check_dependencies)
				{
					$this->dependencies = array_merge($this->dependencies, $open_dependencies);
				}
			}

			// Only run this check after the first run
			if ($check_dependencies)
			{
				$this->check_dependencies();
				$check_dependencies = false;
			}
		}

		ksort($this->tables);
		return $this->tables;
	}

	/**
	* Check if one of the migrations files' dependencies can't be resolved
	* by the supplied list of migrations
	*
	* @throws \UnexpectedValueException If a dependency can't be resolved
	*/
	protected function check_dependencies()
	{
		// Strip duplicate values from array
		$this->dependencies = array_unique($this->dependencies);

		foreach ($this->dependencies as $dependency)
		{
			if (!in_array($dependency, $this->class_names))
			{
				throw new \UnexpectedValueException("Unable to resolve the dependency '$dependency'");
			}
		}
	}
}
