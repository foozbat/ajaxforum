<?
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         fixdefaults.inc.php
	type:         Library
	written by:   Aaron Bishop and PHP.net contributors
	date:         12/24/2005
	description:  Fixes some common PHP configurations that are problematic.
	  This file will incur additional processing overhead in the event that your PHP is not properly configured!
	  Make sure you turn off Magic Quotes, Register Globals, ... in php.ini, or have your web host do it.
*/

// from: http://us3.php.net/manual/en/security.magicquotes.disabling.php
// by:   Niraj Bhawnani
// kill the evil magic quotes if its still on after .htaccess hack
// modified by AB on 1/17/2006 to make it work :)
function arrayStripSlashes(&$array) {
	foreach($array as $key => $value) {
		if (is_array($array[$key])) {
			arrayStripSlashes($array[$key]);
		}
		else {
			$array[$key] = stripslashes($array[$key]);
		}
	}
}

if (get_magic_quotes_gpc()) {
	arrayStripSlashes($_POST);
	arrayStripSlashes($_REQUEST);
	arrayStripSlashes($_GET);
	arrayStripSlashes($_COOKIE);
}


// from: http://us3.php.net/manual/en/function.ini-set.php
// by:   Alan Hogan
// Effectively turn off dangerous register_globals without having to edit php.ini
if (ini_get('register_globals'))  // If register_globals is enabled
{ // Unset $_GET keys
	foreach ($_GET as $get_key => $get_value) {
		if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $get_key)) {
			eval("unset(\${$get_key});");
		}
	} // Unset $_POST keys
	foreach ($_POST as $post_key => $post_value) {
		if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $post_key)) {
			eval("unset(\${$post_key});");
		}
	} // Unset $_REQUEST keys
	foreach ($_REQUEST as $request_key => $request_value) {
		if (ereg('^([a-zA-Z]|_){1}([a-zA-Z0-9]|_)*$', $request_key)) {
			eval("unset(\${$request_key});");
		}
	}
}