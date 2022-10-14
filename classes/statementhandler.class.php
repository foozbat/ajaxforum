<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         statementhandler
	type:         Class Definition
	written by:   Aaron Bishop
	created:      12/24/2005
	updated:      12/26/2005
	description:  
*/

class StatementHandler
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $sql_link;
	var $sql_result;
	var $query_string;
	var $query_parsed;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function StatementHandler(&$sql_link, $query_string)
	{
		$this->sql_link     = $sql_link;
		$this->query_string = $query_string;
	}

	/////////////
	// METHODS //
    /////////////

	// executes a query and stores the result pointer
	function execute()
	{
		$bm = new Benchmark('sth_execute_query');

		$arg_list = func_get_args();
		$this->parse_query($arg_list);

		$this->sql_result = mysql_query($this->query_parsed, $this->sql_link) or die(mysql_error() . 'QUERY: '. $this->query_parsed);

		$bm->end_bench();
	}

	// parses parameters into the query string
	function parse_query($query_values)
	{
		for ($i=0; $i<sizeof($query_values); $i++)
		{
			if ($query_values[$i] != 'NOW()');
				$query_values[$i] = '"'.mysql_escape_string($query_values[$i]).'"';
		}
		array_unshift($query_values, $this->query_string);

		$this->query_parsed = call_user_func_array('sprintf', $query_values);
		$this->query_parsed = str_replace("&#37;", "%", $this->query_parsed);
	}

	// returns the next row of a result set as a normal array
	function fetchrow_array()
	{
		$ret_array = mysql_fetch_row($this->sql_result);
		return sizeof($ret_array) == 1 ? $ret_array[0] : $ret_array;
	}

	// returns the next row of a result set as an associative array
	function fetchrow_assoc()
	{
		return mysql_fetch_assoc($this->sql_result);
	}

	function executed_query()
	{
		return $this->query_parsed;
	}

}