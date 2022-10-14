<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         post.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         1/14/2006
	updated:      1/14/2006
	description:  Responsible for all operations regarding a single post
*/

class Post
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $post_id;
	var $exists;
	var $is_deleted;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function Post($post_id)
	{
		global $db;

		$this->post_id    = $post_id;
		$this->exists     = $db->selectrow_array("SELECT COUNT(*) FROM posts WHERE id=?", $this->post_id);
		$this->is_deleted = $db->selectrow_array("SELECT is_deleted FROM posts WHERE id=?", $this->post_id);
	}

	/////////////
	// METHODS //
    /////////////

	function get_post_data()
	{
		global $db;
		return $db->selectrow_assoc("SELECT * FROM posts WHERE id=?", $this->post_id);
	}

	function write_post($action, $post_data)
	{
		global $db;
		$thread_id = '';

		$post_data['poster_id'] = 1; // CHANGE

		if (!isset($post_data['post_id']))
			$post_data['post_id'] = '';

		// force some values
		$post_data['is_deleted']    = 0;
		$post_data['title']         = htmlspecialchars($post_data['title']);
		$post_data['message_text']  = htmlspecialchars($post_data['message_text']);
		$post_data['use_bbcode']    = isset($post_data['use_bbcode'])    ? 1 : 0;
		$post_data['use_smilies']   = isset($post_data['use_smilies'])   ? 1 : 0;
		$post_data['use_signature'] = isset($post_data['use_signature']) ? 1 : 0;

		// save ip address of poster
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$post_data['poster_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$post_data['poster_ip'] = $_SERVER['REMOTE_ADDR'];

		// create timestamps
		if ($this->exists)
		{
			$post_data['time_edited'] = 'NOW()';
			if (isset($post_data['time_created']))
				unset($post_data['time_created']);
		}
		else
		{
			$post_data['time_created'] = 'NOW()';
			if (isset($post_data['time_edited']))
				unset($post_data['time_edited']);
		}

		// write post
		$query = $db->auto_query('posts', 'id', $post_data['post_id'], $post_data);
		$db->query($query);

		// get new post id
		if ($action == 'newthread' || $action == 'reply')
			$this->post_id = $db->last_insert_id();
		else
			$this->post_id = $post_data['post_id'];

		// if this is a new thread, create new thread record, else find out what thread this is
		if ($action == 'newthread')
		{
			$post_data['first_post_id'] = $this->post_id;
			$thread = new Thread();
			$thread_id = $thread->write_thread($post_data);
		}
		else if ($action == 'edit')
			$thread_id = $db->selectrow_array("SELECT thread_id FROM posts WHERE id=?", $this->post_id);
		else if ($action == 'reply')
			$thread_id = $db->selectrow_array("SELECT thread_id FROM posts WHERE id=?", $post_data['replyto_post_id']);

		// set the thread id
		$db->query("UPDATE posts SET thread_id=? WHERE id=?", $thread_id, $this->post_id);

		// return success or failure
		if ($db->error_message())
			return 0;
		else
			return $thread_id;
	}
}