<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         db.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	created:      12/24/2005
	updated:      12/26/2005
	description:  Database abstraction layer.
*/

include("statementhandler.class.php");

class Database
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $query_string;
	var $query_parsed;
	var $sql_link;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function Database($host, $username, $password, $database)
	{
		$this->connect($host, $username, $password, $database);
	}

	/////////////
	// METHODS //
    /////////////

	function connect($host, $username, $password, $database)
	{
		$this->sql_link = mysql_connect($host, $username, $password) or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db($database, $this->sql_link);
	}

	function disconnect()
	{
		mysql_close($this->sql_link);
	}

	// prepares a query for execution and returns a statement handler
	function prepare($query)
	{
		$this->query_string = str_replace("%", "&#37;", $query);
		$this->query_string = str_replace('?', '%s', $this->query_string);

		$sth =& new StatementHandler($this->sql_link, $this->query_string);

		return $sth;
	}

	// executes a query and returns no rows
	function query()
	{
		$arg_list = func_get_args();
		$this->parse_query($arg_list);

		$this->sql_result = mysql_query($this->query_parsed, $this->sql_link) or die(mysql_error() . 'QUERY: '. $this->query_parsed);
	}

	// executes a query and returns the first row of the result as a normal array
	function selectrow_array()
	{
		$arg_list = func_get_args();
		$this->parse_query($arg_list);

		$this->sql_result = mysql_query($this->query_parsed, $this->sql_link) or die(mysql_error() . 'QUERY: '. $this->query_parsed);

		$ret_array = mysql_fetch_row($this->sql_result);
		return sizeof($ret_array) == 1 ? $ret_array[0] : $ret_array;
	}

	// executes a query and returns the first row of the result as an associative array
	function selectrow_assoc()
	{
		$arg_list = func_get_args();
		$this->parse_query($arg_list);

		$this->sql_result = mysql_query($this->query_parsed, $this->sql_link) or die(mysql_error() . 'QUERY: '. $this->query_parsed);

		return mysql_fetch_assoc($this->sql_result);
	}

	function selectcol_array()
	{
		$arg_list = func_get_args();
		$this->parse_query($arg_list);

		$this->sql_result = mysql_query($this->query_parsed, $this->sql_link) or die(mysql_error() . 'QUERY: '. $this->query_parsed);
	
		$ret_array = array();

		while ($col = mysql_fetch_row($this->sql_result))
			array_push($ret_array, $col[0]);

		return sizeof($ret_array) == 1 ? $ret_array[0] : $ret_array;
	}

	function parse_query($query_values)
	{
		$query_values[0] = str_replace("?", "%s", $query_values[0]);
		for ($i=1; $i<sizeof($query_values); $i++)
		{
			if ($query_values[$i] != 'NOW()');
				$query_values[$i] = "'".mysql_escape_string($query_values[$i])."'";
		}

		$this->query_parsed = call_user_func_array('sprintf', $query_values);
	}

	function last_insert_id()
	{
		return mysql_insert_id();
	}

	// automatically creates a string for inserting/updated values in a query
	function auto_query($table, $table_key, $table_key_value, $data_array)
	{
		$table           = mysql_escape_string($table);
		$table_key       = mysql_escape_string($table_key);
		$table_key_value = mysql_escape_string($table_key_value);

		$query = "INSERT INTO `$table` SET ";

		$row_exists = $this->selectrow_array("SELECT COUNT(*) FROM `$table` WHERE `$table_key` = '$table_key_value'");

		if ($row_exists)
			$query = "UPDATE `$table` SET ";

		$query_columns = array();

		$table_columns = $this->selectcol_array("EXPLAIN `$table`");

		foreach ($data_array as $field => $value)
		{
			if ($field != 'id' && $field != 'last_updated')
			{			
				if ($value != 'NOW()')
					$value = '"'.mysql_escape_string($value).'"';
		
				if (in_array($field, $table_columns))
					array_push($query_columns, "$field = $value");
			}
		}

		$query .= implode(", ", $query_columns);

		if ($row_exists)
			$query .= " WHERE `$table_key` = '$table_key_value'";

		return $query;
	}

	function executed_query()
	{
		return $this->query_parsed;
	}

	function error_message()
	{
		return mysql_error();
	}
}