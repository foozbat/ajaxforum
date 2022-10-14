<?

function mbcode($string)
{
	// QUOTE
	$string = preg_replace("/\[quote\](.*?)\[\/quote\]/si", "<div class=\"quote\">\\1</div>", $string);

	// BOLD
	$string = preg_replace("/(\[b\])/i", "<b>", $string);
	$string = preg_replace("/(\[\/b\])/i", "</b>", $string);
	// ITALICS
	$string = preg_replace("/(\[i\])/i", "<i>", $string);
	$string = preg_replace("/(\[\/i\])/i", "</i>", $string);

	// UNDERLINE
	$string = preg_replace("/(\[u\])/i", "<u>", $string);
	$string = preg_replace("/(\[\/u\])/i", "</u>", $string);

	// LIST
	$string = preg_replace("/(\[list\])/i", "<ul>", $string);
	$string = preg_replace("/(\[\/list\])/i", "</ul>", $string);

	// LI
	$string = preg_replace("/(\[\*\])/i", "<li>", $string);

	// IMAGE SRC
    $string = preg_replace("/\[img\](mailto:)?(\S+?)(\.jpe?g|\.gif|\.png)\[\/img\]/si", "<img src=\"\\2\\3\" border=0 alt=\"\\1\\2\\3\">", $string);

	// FONT
	$string = preg_replace("/\[font=(.*?)\](.*?)\[\/font\]/si", "<font face=\"\\1\">\\2</font>", $string);

	// FONT SIZE
	$string = preg_replace("/\[size=([1-7])\](.*?)\[\/size\]/si", "<font size=\"\\1\">\\2</font>", $string);

	// FONT COLOR
	$string = preg_replace("/\[color=(\S+?)\](.*?)\[\/color\]/si", "<font color=\"\\1\">\\2</font>", $string);

	// HYPERLINK
	$string = preg_replace("/\[url\](http|https|ftp)(:\/\/\S+?)\[\/url\]/si", "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</A>", $string);
    $string = preg_replace("/\[url\](\S+?)\[\/url\]/si", "<a href=\"http://\\1\" target=\"_blank\">\\1</A>", $string);
    $string = preg_replace("/\[url=(http|https|ftp)(:\/\/\S+?)\](.*?)\[\/url\]/si", "<a href=\"\\1\\2\" target=\"_blank\">\\3</A>", $string);
    $string = preg_replace("/\[url=(\S+?)\](\S+?)\[\/url\]/si", "<a href=\"http://\\1\" target=\"_blank\">\\2</A>", $string);

	// EMAIL LINK
    $string = preg_replace("/\[email\](\S+?@\S+?\\.\S+?)\[\/email\]/si", "<a href=\"mailto:\\1\">\\1</A>", $string);
    $string = preg_replace("/\[email=(\S+?@\S+?\\.\S+?)\](.*?)\[\/email\]/si", "<a href=\"mailto:\\1\">\\2</A>", $string);

	return $string;
}

?>