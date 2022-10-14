<?php
/*
	AJAX Form
	written by Aaron Bishop and Mark Roberts
	http://www.needawebsite.com
	Copyright ©2006
	-----------------------
	file:         ajaxforum.inc.php
	type:         initialization library
	written by:   Aaron Bishop
	date:         12/24/2005
	description:  This file loads all necessary libaries and classes.  
	  It performs common initalization routines for all scripts.
*/

error_reporting(E_ALL);

if (!isset($FORUM_ROOT) || $FORUM_ROOT != '../')
	$FORUM_ROOT = './';

// include necessary libraries
require_once($FORUM_ROOT.'include/fixdefaults.inc.php');
require_once($FORUM_ROOT.'include/setup.inc.php');
require_once($FORUM_ROOT.'include/common_functions.inc.php');

// include classes
require_once($FORUM_ROOT.'classes/benchmark.class.php');
require_once($FORUM_ROOT.'classes/settings.class.php');
require_once($FORUM_ROOT.'classes/database.class.php');
require_once($FORUM_ROOT.'classes/fileobject.class.php');
require_once($FORUM_ROOT.'classes/requiredfields.class.php');
require_once($FORUM_ROOT.'classes/cgi.class.php');
require_once($FORUM_ROOT.'classes/xml.class.php');
require_once($FORUM_ROOT.'classes/devlog.class.php');
require_once($FORUM_ROOT.'classes/renderer.class.php');
require_once($FORUM_ROOT.'classes/thread.class.php');
require_once($FORUM_ROOT.'classes/post.class.php');

// benchmark entire page
$main_bm = new Benchmark('total_time');

// instantiate global objects
$db       =& new Database($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE_NAME);
$settings =& new Settings();
$renderer =& new Renderer();
$cgi      =& new CGI();
$devlog   =& new DevLog('initialdev1');

// Assign some global rendering vars.
$renderer->assign('mod_path', 'mods/'.$settings->get_value('forum_mod'));

// Check for user created script mods
$path_components = explode('/', $_SERVER['PHP_SELF']);
$script_name = array_pop($path_components);

if (file_exists($FORUM_ROOT.'mods/'.$settings->get_value('forum_mod').'/modules/internal_'.$script_name))
	require_once($FORUM_ROOT.'mods/'.$settings->get_value('forum_mod').'/modules/internal_'.$script_name);
else
	require_once($FORUM_ROOT.'modules/internal_'.$script_name);

// clean up
$devlog->destroy();
$db->disconnect();

// stop benchmarking
$main_bm->end_bench();
if ($settings->get_value('show_benchmark') && !preg_match('/ajax/', $script_name))
	benchmark_page();

// done,
// bye!