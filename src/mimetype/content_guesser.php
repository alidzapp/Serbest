<?php

namespace src\mimetype;

class content_guesser extends guesser_base
{
	/**
	* {@inheritdoc}
	*/
	public function is_supported()
	{
		return function_exists('mime_content_type') && is_callable('mime_content_type');
	}

	/**
	* {@inheritdoc}
	*/
	public function guess($file, $file_name = '')
	{
		return mime_content_type($file);
	}
}
