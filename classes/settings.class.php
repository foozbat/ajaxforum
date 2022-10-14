<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         settings.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	created:      12/24/2005
	updated:      12/26/2005
	description:  Object that holds all settings for the forum.
	  Settings are stored in the database.
*/

class Settings
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $setting_values;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function Settings()
	{
		global $db;

		$sth = $db->prepare("SELECT setting_name, setting_value FROM settings");
		$sth->execute();

		while(list($name, $value) = $sth->fetchrow_array())
		{
			$this->setting_values[$name] = $value;
		}
	}

	/////////////
	// METHODS //
    /////////////

	function get_value($setting_name)
	{
		return $this->setting_values[$setting_name];
	}

	function get_label($setting_name)
	{
		return $db->selectrow_array("SELECT setting_label FROM settings WHERE setting_name=?", $setting_name);
	}
}