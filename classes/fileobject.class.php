<?php
/* 
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         fileobject.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         12/24/2005
	description:  This class is a wrapper for opening, reading, writing, and closing a file.
*/

class FileObject
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $file_pointer;
	var $filename;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function FileObject($filename, $flags)
	{
		global $FORUM_ROOT;
		$this->filename = $FORUM_ROOT.$filename;
		$this->file_pointer = fopen($FORUM_ROOT.$filename, $flags);
	}

	/////////////
	// METHODS //
    /////////////

	function get_data($start, $length)
	{
		rewind($this->file_pointer);
		fseek($this->file_pointer, $start);

		return fread($this->file_pointer, $length);
	}

	function write_data($raw)
	{
		fwrite($this->file_pointer, $raw, strlen($raw));
	}

	function write_data_at($raw, $start)
	{
		rewind($this->file_pointer);
		fseek($this->file_pointer, $start);

		fwrite($this->file_pointer, $raw, strlen($raw));
	}

	function size()
	{
		return filesize($this->filename);
	}

	function destroy()
	{
		fclose($this->file_pointer);
	}
}

// converts an integer to an ascii formatted binary value
function int2chars($int_val)
{
	return chr( ($int_val & 0xFF000000) >> 24 ) . 
		   chr( ($int_val & 0x00FF0000) >> 16 ) . 
		   chr( ($int_val & 0x0000FF00) >> 8  ) . 
		   chr(  $int_val & 0x000000FF );
}

// converts an ascii formatted binary value to an integer
function chars2int($string_val)
{
	return ( ord($string_val{0}) << 24 ) |
		   ( ord($string_val{1}) << 16 ) |
		   ( ord($string_val{2}) << 8  ) |
		   ( ord($string_val{3}));
}