<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         user.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         2/15/2006
	updated:      2/15/2006
	description:  Responsible for all operations regarding a single user
*/

class User
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $user_id;
	var $exists;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function User($user_id)
	{
		$this->user_id = $user_id;
		$this->exists  = $db->selectrow_array("SELECT COUNT(*) FROM users WHERE id=?", $this->user_id);
	}

	/////////////
	// METHODS //
    /////////////

	function get_user_data()
	{
		global $db;
		return $db->selectrow_assoc("SELECT * FROM users WHERE id=?", $this->user_id);
	}

	function write_user_data()
	{
		//

		if ($db->error_message())
			return 0;
		else
			return $this->user_id;
	}
}