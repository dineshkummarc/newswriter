<?php
/**************************************************************************
*                               Newswriter 1.5                            *
*                          -----------------------                        *
*   begin                  :  Friday, Jan 30, 2007                        *
*   coded by               :  Udo Seiler                                  *
*   copyright              :  (C) webfire.biz 2007                        *
*   email                  :  mail@webfire.biz                            *
*                                                                         *
*   $Id: index.php|config.php|admin.php, v 1.5 - 2007/01/30 20:35:00      *
*                                                                         *
**************************************************************************/
$web = 'http://www.webfire.biz';
/**************************************************************************
*                                                                         *
*   This program is free software; you can redistribute it and/or modify  *
*   it under the terms of the GNU General Public License as published by  *
*   the Free Software Foundation; either version 2 of the License, or     *
*   (at your option) any later version.                                   *
*                                                                         *
**************************************************************************/

define('USERNAME', 		'admin');																// your login name
define('PASSWORD', 		'admin');																// your login password
define('PAGE_TITLE', 	'Newswriter v.1.5');										// Page title
define('DATA_FILE', 	'content.dat');													// where the data will be saved
define('NO_NEWS', 		'No news available!');									// message if no news
define('WELCOME', 		'<b>Newswriter Administration</b>');		// welcome message


//-------------------------------------------------------------------------|
//    If you don't know what you do, don't edit beyond this line!          |
//-------------------------------------------------------------------------|

if (!is_writable(DATA_FILE)) die ('<b>'.DATA_FILE.' is not writable or does not exist!</b>');

function htmlhead($links='')
{
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html><head>
	<TITLE><?=PAGE_TITLE ?></TITLE>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1" />
	<SCRIPT TYPE="text/javascript" SRC="help.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css">
	
	</HEAD>
	<BODY BGCOLOR=#E8E8CD LEFTMARGIN=0 TOPMARGIN=10 MARGINWIDTH=0 MARGINHEIGHT=0>
	<center>
	<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD align="center">
		<br><IMG SRC="logo.jpg"><br><br><br>
		</TD>
	</TR>
	</TABLE>
	
	<br>
	<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD align="center" WIDTH=750 HEIGHT=30 bgcolor="#cccccc">
	<?php
	if ( $links == 'on')
	{
	?>
		<a href="<?=$_SERVER['PHP_SELF'] ?>?action=new" class="subnavi">Create News</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="<?=$_SERVER['PHP_SELF'] ?>?action=show" class="subnavi">Show News</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="#" onclick="help();" class="subnavi">Help</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="<?=$_SERVER['PHP_SELF'] ?>?action=logout" class="subnavi">Logout</a>
	<?php
	}
	else { print '<span class="subnavi">'.$links.'</span>'; }
	?>
		</TD>
	</TR>
	<TR>
		<TD><IMG SRC="line.gif" WIDTH=750 HEIGHT=1 ALT=""></TD>
	</TR>
	</TABLE>
	<?php
}

function htmlfooter($links='')
{
	?>
	<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
	<TR>
	<TD height=20></TD>
	</TR>
	</TABLE>

	<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD><IMG SRC="line.gif" WIDTH=750 HEIGHT=1 ALT=""></TD>
	</TR>
	<TR>
		<TD align="center" WIDTH=750 HEIGHT=30 bgcolor="#cccccc">
		<a href="admin.php" class="subnavi"><?=$links ?></a>
		</TD>
	</TR>
	</TABLE>
	<br><br><br>
	<span class="copy"><a href="http://newswriter2005.sourceforge.net/" class="copy">Newswriter</a> v1.5<br>Copyright &copy; 2007 Udo Seiler - <a href="http://www.webfire.biz/" class="copy">Webfire.biz</a></span>
	</center>
	</BODY></HTML>
	<?php
}

function loginscreen()
{
	?>
	<TABLE height=200 WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
	<TR>
		<TD height=35></TD>
	</TR>
	<TR>
		<TD WIDTH=370>
			<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
			<input type="hidden" name="action" value="login">
		</TD>
		<TD valign="middle" WIDTH=50>

			<b>Name:</b>
		</TD>
		<TD valign="middle" WIDTH=350>
			
			<input style="width:120px" type="text" size="20" maxlength="15" name="name">
		</TD>
	</TR>
	<TR>
		<TD WIDTH=370></TD>
		
		<TD valign="middle" WIDTH=50>
		
			<b>Pass:</b>
		</TD>
		<TD valign="middle" WIDTH=550>
	
			<input style="width:120px" type="password" size="20" maxlength="15" name="pass">
		</TD>
	</TR>
	<TR>
		<TD></TD>
		<TD></TD>
		<TD valign="middle" WIDTH=550>

			<input style="width:120px" type="submit" value="Login">
		</form>
		</TD>
	</TR>
	</TABLE>
	<?php
}

function get_news()
{
		$serialized = file_get_contents(DATA_FILE);
		return (empty($serialized))? FALSE : unserialize($serialized);
}

function save_news()
{
		global $news;
		ksort ($news);
		
		$data = serialize(array_values($news));
		$fp 	= fopen(DATA_FILE,"w+");
						fputs($fp,$data);
						fclose($fp);

		header("Location: ".$_SERVER['PHP_SELF']."?action=show"); 	// Stop the reload problem 
}	

?>