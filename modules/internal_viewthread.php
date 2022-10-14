<?
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         internal_index.php
	type:         Script
	written by:   Aaron Bishop
	date:         12/24/2005
	updated:      1/14/2006
	description:  Displays a thread.
*/

if ($cgi->get('id') === NULL)
{
	$renderer->assign('invalid_thread_id', 1);
	$renderer->display('error');
	exit;
}

$thread = new Thread($cgi->get('id'));

if (!$thread->exists)
{
	$renderer->assign('invalid_thread_id', 1);
	$renderer->display('error');
	exit;
}

$info = $thread->basic_info();
$thread_post_nums = $thread->get_post_ids();

$renderer->assign('forum_sub_title',  $info['title']);
$renderer->assign('thread_post_nums', $thread_post_nums);
$renderer->assign('thread_id',        $cgi->get('id'));

$renderer->display('viewthread');