<?= '<?xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sp" lang="sp"><head>
<title><?= $forum_title ?><? if ($forum_sub_title) print " - ".$forum_sub_title ?></title>
<link rel="stylesheet" href="<?= $mod_path ?>/style.css" type="text/css" />
</head>

<body>

<div id="main_page">

<span style="font-size: 24pt; font-weight: bold">Teh unnamed f0rum!</span>

<br /><br />

<table width="100%" class="normal">
<tr><td class="header_titlecell">Forum Information:</td><td class="header_titlecell">Logged in as:</td></tr>
<tr>
	<td class="topinfo" valign="top">
	Total Members: <b>XXX</b><br />

	Total Threads: <b>XXX</b><br />
	Total Posts: <b>XXX</b><br />
	Our newest member is <a href="viewprofile.php?member=">???</a>
	</td>
	<td class="topinfo">
		<b>???</b><br />
		custom name<br />
		number of posts: XX<br />
		times replies to: XX								
	</td>
</tr>
<tr>
	<td colspan="2" class="menucell">
	<table width="100%" class="menulinks">
	<tr>
		<td class="invisible" align="center"><a class="toplink" href="./">Main Forum</a></td>
		<td class="invisible" align="center"><a class="toplink" href="register.php">Register</a></td>
		<td class="invisible" align="center"><a class="toplink" href="modifyprofile.php">My Profile</a></td>
		<td class="invisible" align="center"><a class="toplink" href="pm.php">Private Messages</a></td>
		<td class="invisible" align="center"><a class="toplink" href="login.php">Login</a></td>
		<td class="invisible" align="center"><a class="toplink" href="memberlist.php">Member List</a></td>
		<td class="invisible" align="center"><a class="toplink" href="faq.php">F.A.Q.</a></td>
		<td class="invisible" align="center"><a class="toplink" href="search.php">Forum Search</a></td>
	</tr>
	</table>
	</td>
</tr>
</table>

<br /><br />