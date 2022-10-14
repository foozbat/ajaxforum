<?
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         thread.class.php
	type:         Class Definition
	written by:   Aaron Bishop
	date:         1/9/2006
	updated:      1/9/2006
	description:  handles retreiving of thread data
*/

class Thread
{
	//////////////////
	// DATA MEMBERS //
	//////////////////

	var $thread_id;
	var $page_num;
	var $view_since;
	var $exists;

	/////////////////
	// CONSTRUCTOR //
	/////////////////

	function Thread($thread_id=0, $page_num=1, $view_since=0)
	{
		global $db;
		$this->thread_id  = $thread_id;
		$this->page_num   = $page_num;
		$this->view_since = $view_since;
		$this->exists     = $db->selectrow_array("SELECT COUNT(*) FROM threads WHERE id=?", $this->thread_id);
	}

	/////////////
	// METHODS //
    /////////////

	function get_thread_xml()
	{
		global $db;

		$query = "SELECT id, title, forum_id, sticky, locked FROM threads WHERE id=?";
		if ($this->view_since)
			$query .= " AND last_updated >= ?";

		$thread = array();
		$thread['thread'] = $db->selectrow_assoc($query, $this->thread_id, $this->view_since);
		$thread['thread']['post'] = array();

		$query = 
<<<__SQL__
			SELECT 
				posts.id, 
				DATE_FORMAT(time_created,'%m/%d/%Y') as time_created,
				title, 
				message_text, 
				replyto_post_id, 
				username as poster_name,
				poster_id,
				is_deleted
			FROM posts 
			JOIN users ON poster_id=users.id 
			WHERE thread_id=?
__SQL__;

		$sth = $db->prepare($query);
		$sth->execute($this->thread_id);

		while ($post = $sth->fetchrow_assoc())
		{
			// don't send XML with lots of data if this thread is deleted
			if ($post['is_deleted'])
				$post = array('id' => $post['id'], 'is_deleted' => 1);
			else
			{
				$post['message_text'] = mbcode($post['message_text']);
				
				$post['poster_num_posts'] = $db->selectrow_array("SELECT COUNT(*) FROM posts WHERE poster_id=?", $post['poster_id']);

				// get attachments
				
				$isth = $db->prepare("SELECT id, filename, filesize FROM attachments WHERE post_id=?");
				$isth->execute($post['id']);

				while ($attachment = $isth->fetchrow_assoc())
				{
					if (!isset($post['attachment']))
						$post['attachment'] = array();
					array_push($post['attachment'], $attachment);
				}
			}

			array_push($thread['thread']['post'], $post);
		}

		return make_xml($thread);
	}

	function write_thread($thread_data)
	{
		global $db;

		$query = $db->auto_query('threads', 'id', $thread_data['thread_id'], $thread_data);

		$db->query($query);

		// return success or failure
		if ($db->error_message())
			return 0;
		else
			return $db->last_insert_id();
	}

	// returns the unique post ids of all the posts in this set
	function get_post_ids()
	{
		global $db;

		$ids = array();

		$sth = $db->prepare("SELECT id FROM posts WHERE thread_id=?");
		$sth->execute($this->thread_id);

		while ($id = $sth->fetchrow_array())
			array_push($ids, $id);

		return $ids;
	}

	function basic_info()
	{
		global $db;
		return $db->selectrow_assoc("SELECT * FROM threads JOIN posts ON first_post_id = posts.id WHERE threads.id=?", $this->thread_id);
	}
}