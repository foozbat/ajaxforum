<?php
/* 
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         devlog.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	created:      12/24/2005
	updated:      12/26/2005
	description:  This class lets you write interesting things into a log file.
*/

class DevLog
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $logfile;
	
	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function DevLog($logfilename)
	{
		global $FORUM_ROOT;
		global $settings;

		if ($settings->get_value('allow_logging'))
		{
			$this->logfile = new FileObject('logs/'.$logfilename.'.txt', 'a');
			chmod($FORUM_ROOT.'logs/'.$logfilename.'.txt', 0777);
		}
	}

	/////////////
	// METHODS //
    /////////////

	function put($string)
	{
		global $settings;
		if ($settings->get_value('allow_logging'))
			$this->logfile->write_data($string."\n");
	}

	function destroy()
	{
		global $settings;
		if ($settings->get_value('allow_logging'))
		{
			$this->logfile->destroy();
		}
	}
}