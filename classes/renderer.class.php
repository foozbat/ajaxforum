<?php
/* 
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright Â©2006
	-----------------------
	file:         renderer.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         12/24/2005
	description:  This class contains handles the assignment of render variables and the displaying of templates
*/

class Renderer
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $render_vars;
	var $selects;
	var $checks;
	var $texts;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function Renderer()
	{
		$selects = array();
		$checks = array();
		$texts = array();
	}

	/////////////
	// METHODS //
    /////////////

	function assign($name, $value)
	{
		$this->render_vars[$name] = $value;
	}

	function defineloop($name)
	{
		$this->render_vars[$name] = array();
	}

	function addlooprow($name, $value)
	{
		if (!isset($this->render_vars[$name]))
			$this->render_vars[$name] = array();
		array_push($this->render_vars[$name], $value);
	}

	// renders and displays a specified page
	function display($page)
	{
		global $settings;

		// start output buffering
		if ($settings->get_value('use_gzip'))
			ob_start('ob_gzhandler');
		else
			ob_start();

		// do rendering
		$this->render($page);

		// send buffered output to the browser
		ob_end_flush();
	}

	// internal function for the rendering of pages.  do not call this function directly!  use display()
	function render($page)
	{
		global $settings;

		$forum_title = $settings->get_value('forum_title');

		$bm = new Benchmark('rendering');

		// create a local variable for each render var
		extract($this->render_vars, EXTR_SKIP);

		$r = &$this;
	
		// send nifty no cache headers
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');

		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

		$template_file = $mod_path.'/templates/template_'.$page.'.php';

		if (file_exists($template_file))
			require_once($template_file);
		else
		{
			$cannot_find_template = 1;
			require_once($mod_path.'/templates/template_error.php');
		}

		error_reporting(E_ALL);

		$bm->end_bench();
	}

	// renders the page and returns output as a string instead of sending to the browser
	function render_as_string($page)
	{
		ob_start();
		$this->render($page);
		return ob_get_clean();
	}

	function redirect($location)
	{
		header("Location: $location");
		exit;
	}

	// SELECT, CHECK, RADIO AUTOCOMPLETION
	function defineselect($name)
	{
		$this->selects[$name] = array();
	}

	function addselectitems($name, $array)
	{
		foreach ($array as $value => $text)
			$this->selects[$name][$value] = array($text, 0);
	}

	function addselectitem($name, $value, $text, $selected=0)
	{
		$this->selects[$name][$value] = array($text, $selected);
	}

	function addtextitem($name, $value)
	{
		$this->texts[$name] = $value;
	}

	function setselected($name, $selected)
	{
		if (is_array($selected))
		{
			foreach($selected as $x)
			{
				if (isset($this->selects[$name][$x]))
					$this->selects[$name][$x][1] = 1;
			}
		}
		else
			if (isset($this->selects[$name][$selected]))
				$this->selects[$name][$selected][1] = 1;
	}

	function SelectBox($name, $size=0, $multiple=0, $extraparams='')
	{
		if (isset($this->selects[$name]))
		{
			echo '<select name="'.htmlspecialchars($name).'"';
			if ($multiple) echo ' multiple';
			if ($size) echo ' size='.$size;
			echo " $extraparams>\n";

			foreach($this->selects[$name] as $value => $data)
			{
				list($text, $selected) = $data;
				echo '<option value="'.htmlspecialchars($value).'"';
				if ($selected) echo ' selected';
				echo '>'.htmlspecialchars($text)."</option>\n";
			}
			echo "</select>\n";
		}
	}

	function TextBox($name, $size=20, $extraparams='')
	{
		if (isset($this->texts[$name]))
			$text = $this->texts[$name];
		else
			$text = '';

		echo '<input type="text" name="'.$name.'" size="'.$size.'" value="'.$text.'" '.$extraparams.'>';
	}

	function TextArea($name, $cols=40, $rows=5, $extraparams='')
	{
		if (isset($this->texts[$name]))
			$text = $this->texts[$name];
		else
			$text = '';

		echo '<textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'" '.$extraparams.'>';
		echo $text;
		echo '</textarea>';
	}
}