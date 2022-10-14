<? require_once("template_header.php"); ?>

<? if (sizeof($missing_fields) > 0 || sizeof($invalid_fields)) { ?>
	<table class="normal">
	<tr>
		<td class="titlebar">
			You have not completed one or more required fields.
		</td>
	</tr>
	<tr>
		<td class="rightcell">
			<ul>
			<? foreach ($missing_fields as $field) { ?>
				<? if ($field == 'title') { ?>
				<li />You must specify a title for the thread.
				<? } ?>

				<? if ($field == 'message_text') { ?>
				<li />You must type a message.
				<? } ?>
			<? } ?>
			</ul>
		</td>
	</tr>
	</table>
	<br /><br />
<? } ?>

<form action="postmessage.php" method="post">
<table class="normal">
<tr>
	<td class="titlebar" colspan="2">
		<? if ($action == 'newthread') { ?>
			Post New Thread
		<? } else if ($action == 'reply') { ?>
			Post Reply
		<? } else if ($action == 'edit') { ?>
			Edit Post
		<? } ?>
	</td>
</tr>
<tr>
	<td class="leftcell"><b>Title:</b></td>
	<td class="rightcell"><input type="text" name="title" size="60" value="<?= $post_title ?>" /></td>
</tr>
<tr>
	<td class="leftcell" valign="top"><b>Message:</b></td>
	<td class="rightcell">
		<textarea name="message_text" cols="60" rows="12"><?= $post_message_text ?></textarea>
	</td>
</tr>
<tr>
	<td class="leftcell" valign="top"><b>Options:</b></td>
	<td class="rightcell">
		<input type="checkbox" name="use_bbcode"    value="1" <? if ($post_use_bbcode)    print 'checked="checked"'; ?> /> Use BBCode<br />
		<input type="checkbox" name="use_smilies"   value="1" <? if ($post_use_smilies)   print 'checked="checked"'; ?> /> Use Graphical Smilies<br />
		<input type="checkbox" name="use_signature" value="1" <? if ($post_use_signature) print 'checked="checked"'; ?> /> Show your Signature<br />
	</td>
</tr>
<tr>
	<td class="formcell" colspan="2" align="center"><input type="submit" name="submit" value="Post Message" /> <input type="submit" name="preview" value="Preview" />
	
	<input type="hidden" name="action"     value="<?= $action ?>" />
	<? if ($forum_id)   { ?><input type="hidden" name="forum_id"   value="<?= $forum_id ?>"  /><? } // END IF ?>
	<? if ($thread_id)  { ?><input type="hidden" name="thread_id"  value="<?= $thread_id ?>" /><? } // END IF ?>
	<? if ($post_id)    { ?><input type="hidden" name="post_id"    value="<?= $post_id ?>"   /><? } // END IF ?>
	<? if ($replyto_post_id) { ?><input type="hidden" name="replyto_post_id" value="<?= $replyto_post_id ?>"/><? } // END IF ?>

	</td>
</tr>
</table>
</form>


<? require_once("template_footer.php"); ?>