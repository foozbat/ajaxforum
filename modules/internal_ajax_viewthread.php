<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         internal_ajax_viewthread.php
	type:         Script
	written by:   Aaron Bishop
	date:         1/9/2006
	description:  Sends XML for thread posts.
*/

// send some xml
header("Content-type: text/xml");

if (!$cgi->get('id'))
	error();

$thread = new Thread($cgi->get('id'));

if (!$thread->exists)
	error();

print $thread->get_thread_xml();


function error()
{
	$error = array('errors' => array('error' => 'Invalid thread id'));
	print make_xml($error);
	exit;
}