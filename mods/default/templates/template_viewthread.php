<? require_once("template_header.php"); ?>

<!-- 
	MARK: to access the id of this thread, use:
	<?= $thread_id ?>
-->

<span class="header">View Thread</span>

<br /><br />

<!-- POST CONTAINERS -->
<? foreach ($thread_post_nums as $post_num) { ?>
<div id="post_<?= $post_num ?>"></div>
<? } ?>
<!-- /POST CONTAINERS -->

<!-- POST TEMPLATE -->
<div id="post_template" style="display: none">
<table class="normal" width="100%">
<tr>
	<td valign="top" class="membernamecell">
		<a href="" class="profilelink">~%poster_name%~</a><br />
	</td>
	<td class="infocell">
		<div style="float:right">[ ~%post_num%~ of ~%thread_length%~ ]</div>
		To: ~%replyto_poster_name%~ :: 
		#~%post_id%~ in reply to ~%replyto_id%~ :: 
		~%time_posted%~
	</td>
</tr>
<tr>
	<td class="memberinfocell">
		<span class="customname">custom name</span><br /><br />
		~%poster_avatar_link%~<br />
		<span class="memberinfo">
		Join Date: ~%poster_join_date%~<br />
		Posts: ~%poster_posts%~<br />
		Location: ~%poster_location%~
		</span>
	</td>
	<td valign="top" class="messagecell">
	
	~%messagetext%~

	<? if ($post_data["time_edited"]) { ?>
	<p>
	last edit: <? print $post_data["time_edited"] ?>
	<? } // END IF ?>

	</td>
</tr>
<tr>
	<td valign="top" class="memberinfocell2"></td>
	<td class="replycell" valign="middle">
		<div style="float:right">
		<table class="replybox">
		<tr>
			<td><img src="<?= $mod_path ?>/images/reply.gif" width="18" height="18" alt="" /></td>
			<td><a href="<? print $post_data["link_reply"] ?>">Reply</a> | </td>
			<td><img src="<?= $mod_path ?>/images/reply.gif" width="18" height="18" alt="" /></td>
			<td><a href="<? print $post_data["link_reply_quote"] ?>">Reply w/ Quote</a>&nbsp;</td>
			<td>| </td>
			<td><img src="<?= $mod_path ?>/images/edit.gif" width="18" height="18" alt="" /></td>
			<td><a href="<? print $post_data["link_edit"] ?>">Edit</a> | </td>
			<td><img src="<?= $mod_path ?>/images/delete.gif" width="18" height="18" alt="" /></td>
			<td><a href="<? print $post_data["link_delete"] ?>">Delete</a>&nbsp;</td>
		</tr>
		</table>
		</div>
	</td>
</tr>
</table>
</div>
<!-- /POST TEMPLATE -->

<? require_once("template_footer.php"); ?>