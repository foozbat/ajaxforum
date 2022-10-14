<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         cgi.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         1/14/2006
	updated:      1/14/2006
	description:  allows safe access to GET and POST vars
*/

class CGI
{
	function get($name)
	{
		if (isset($_GET[$name]))
			return $_GET[$name];
		else
			return NULL;
	}

	function post($name)
	{
		if (isset($_POST[$name]))
			return $_POST[$name];
		else
			return NULL;
	}

	function param($name)
	{
		if (isset($_GET[$name]))
			return $_GET[$name];
		else if (isset($_POST[$name]))
			return $_POST[$name];
		else
			return NULL;
	}

	function all_get_vars()
	{
		return $_GET;
	}

	function all_post_vars()
	{
		return $_POST;
	}

}