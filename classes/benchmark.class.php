<?php
/* 
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright Â©2006
	-----------------------
	file:         benchmark.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	created:      12/24/2005
	updated:      12/26/2005
	description:  Keeps track of time from when benchmark starts to when benchmark ends.
*/

$BENCHMARKS = array();

class Benchmark
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $time_start;
	var $time_end;
	var $name;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function Benchmark($name)
	{
		$this->name = $name;
		$this->time_start = $this->getmicrotime();
	}

	/////////////
	// METHODS //
    /////////////

	function end_bench()
	{
		$this->time_end = $this->getmicrotime();
		global $BENCHMARKS;
		$BENCHMARKS[$this->name] = $this->time_end - $this->time_start;
	}

	function getmicrotime()
	{ 
		list($usec, $sec) = explode(' ',microtime()); 
		return ((float)$usec + (float)$sec); 
	}

}

function benchmark_page()
{
	global $BENCHMARKS;
	?>
	<br />
	<br />
	<pre>BENCHMARKING:</pre>
	<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="invisible"><u><b>operation<?= "\t\t" ?></u></b></td>
		<td class="invisible"><u><b>time elapsed</b></u></td>
	</tr>
	<?
	$total = 0;
	foreach ($BENCHMARKS as $section => $time)
	{
		$total += $time;
	?><tr><td class="invisible"><?= $section ?></pre></td><td class="invisible"><?= round($time,4) ?></pre></td></tr><?
	}
	?>
	</table>
	<?
}