<?php

namespace src;

/**
* Class recursive_dot_prefix_filter_iterator
*
* This filter ignores directories starting with a dot.
* When searching for php classes and template files of extensions
* we don't need to look inside these directories.
*/
class recursive_dot_prefix_filter_iterator extends \RecursiveFilterIterator
{
	public function accept()
	{
		$filename = $this->current()->getFilename();
		return !$this->current()->isDir() || $filename[0] !== '.';
	}
}
