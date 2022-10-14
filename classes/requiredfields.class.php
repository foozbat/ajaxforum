<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         requiredfields.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         1/14/2006
	updated:      1/14/2006
	description:  allows automatic validation of CGI params
*/

class RequiredFields
{
	var $module;
	var $missing_fields;
	var $invalid_fields;

	function RequiredFields($module)
	{
		global $cgi;
		global $db;

		$this->module = $module;
		$this->missing_fields = array();
		$this->invalid_fields = array();

		$sth = $db->prepare("SELECT field, regex FROM required_fields WHERE module=?");
		$sth->execute($this->module);

		while (list($field, $regex) = $sth->fetchrow_array())
		{
			if (!$cgi->param($field))
				array_push($this->missing_fields, $field);
			else if ($regex)
				if (!preg_match($regex, $cgi->param($field)))
					array_push($this->invalid_fields, $field);
		}
	}

	// returns 1 for valid, 0 for invalid
	function validate()
	{
		return (sizeof($this->missing_fields) > 0 || sizeof($this->invalid_fields) ? 0 : 1);
	}
}