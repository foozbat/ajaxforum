<? require_once("template_header.php"); ?>

<span class="header">Error</span>
<br /><br />

<? if ($db_error) { ?>
A database error has occured:
<br /><br />
<?= $db_error ?>
<? } // END IF ?>

<? if ($cannot_find_template) { ?>
The specified template could not be found.
<? } // END IF ?>

<? if ($invalid_parameters) { ?>
Invalid parameters.
<? } // END IF ?>

<? if ($invalid_thread_id) { ?>
Invalid thread ID specified.
<? } // END IF ?>

<? if ($invalid_forum_id) { ?>
Invalid forum ID specified.
<? } // END IF ?>


<? require_once("template_footer.php"); ?>