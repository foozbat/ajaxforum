<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         internal_postmessage.php
	type:         Script
	written by:   Aaron Bishop
	date:         1/14/2006
	updated:      1/14/2006
	description:  allows posts, edits, and replies
*/

// tell the template what we're doing
if ($cgi->param('action') == 'newthread'  && $cgi->param('forum_id')   && !$cgi->param('post_id')    && !$cgi->param('replyto_post_id') )
	$renderer->assign('new_thread', 1);
else if ($cgi->param('action') == 'reply' && $cgi->param('replyto_post_id') && !$cgi->param('post_id')    && !$cgi->param('forum_id')   )
	$renderer->assign('reply', 1);
else if ($cgi->param('action') == 'edit'  && $cgi->param('post_id')    && !$cgi->param('replyto_post_id') && !$cgi->param('forum_id')   )
	$renderer->assign('edit', 1);
else
{
	// user is trying to haxor
	$renderer->assign('invalid_parameters', 1);
	$renderer->display('error');
	exit;
}

$post =& new Post($cgi->param('post_id'));

// don't allow someone to edit a deleted post
if ($post->is_deleted)
{
	$renderer->assign('post_is_deleted', 1);
	$renderer->display('error');
	exit;
}

// set default checkbox values
$renderer->assign('post_use_bbcode',    1);
$renderer->assign('post_use_smilies',   1);
$renderer->assign('post_use_signature', 1);

// assign existing post data to template
if ($cgi->param('action') == 'edit')
{
	$post_data = $post->get_post_data();

	if (is_array($post_data))
	{
		foreach ($post_data as $name => $value)
			$renderer->assign('post_'.$name, $value);
	}
}

// if replying with quote, prefill message box with quote text
if ($cgi->param('action') == 'reply' && $cgi->param('withquote'))
{
	$quoted_post =& new Post($cgi->param('replyto_post_id'));
	$quoted_post_data = $quoted_post->get_post_data();
	$renderer->assign('post_message_text', "[quote]\n".$quoted_post_data['message_text']."\n[/quote]");
}

if ($cgi->param('submit'))
{
	foreach ($cgi->all_post_vars() as $name => $value)
		$renderer->assign('post_'.$name, $value);

	$required_fields =& new RequiredFields('postmessage');

	if (!$required_fields->validate())
	{
		$renderer->assign('missing_fields', $required_fields->missing_fields);
		$renderer->assign('invalid_fields', $required_fields->invalid_fields);
	}
	else
	{
		$post_data = $cgi->all_post_vars();

		$thread_id = $post->write_post($cgi->param('action'), $post_data);

		if ($thread_id)
			$renderer->redirect('viewthread.php?id='.$thread_id);
		else
		{
			$renderer->assign('db_error', $db->error_message());
			$renderer->display('error');
			exit;
		}
		// end of script execution
	}
}

$renderer->assign('post_id',         $cgi->param('post_id'));
$renderer->assign('thread_id',       $cgi->param('thread_id'));
$renderer->assign('forum_id',        $cgi->param('forum_id'));
$renderer->assign('replyto_post_id', $cgi->param('replyto_post_id'));
$renderer->assign('action',          $cgi->param('action'));

$renderer->display('postmessage');