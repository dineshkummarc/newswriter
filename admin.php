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

/**************************************************************************
*                                                                         *
*   This program is free software; you can redistribute it and/or modify  *
*   it under the terms of the GNU General Public License as published by  *
*   the Free Software Foundation; either version 2 of the License, or     *
*   (at your option) any later version.                                   *
*                                                                         *
**************************************************************************/

session_start();

@(include('config.php')) OR die ('<b>config.php not found!</b>');

$action 	= $_REQUEST['action'];
$go 			= $_POST['go'];
$nr 			= $_POST['nr'];
$text 		= $_POST['text'];
$name 		= $_POST['name'];
$pass 		= $_POST['pass'];

// session check
if ( $action == 'login' && $name == USERNAME && $pass == PASSWORD || empty($action) && $_SESSION['login'] )
{
	$_SESSION['login'] = TRUE;
	htmlhead('on');
	print '
		<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
		<TR>
			<TD>
			<br>
			<center>
			<br><br><br>
			'.WELCOME.'
			<br><br><br>
			</TD>
		</TR>
		</TABLE>
		';
	htmlfooter();
}
if ( $action == 'logout' || !$_SESSION['login'] )  // login-logout-screen
{	
	unset($_SESSION['login']);
	if ( $action == 'xx' ) header("Location: ".$web);
	
	htmlhead('Administration');
	loginscreen();
	htmlfooter();
}
else 
{
	$news = get_news();
	krsort($news);

// new -->
	if ( $action == 'new' )
	{
		htmlhead('on');
	?>
		<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
		<TR>
			<TD colspan=5><br><br></TD>
		</TR>
		<TR>
			<TD WIDTH=50></TD>
			<TD WIDTH=500 valign=top>
				<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
				<textarea style="width:500px;height:150px" wrap=PHYSICAL name="text"></textarea> 
			</TD>
			<TD WIDTH=40></TD>	
			<TD WIDTH=110 align=right valign=middle>
				<input type=hidden name=action value="save" />
				<input type=hidden name=nr value="new" />
				<input style="width:100px" type="submit" value="Speichern" />
				</form>
				<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
				<input type=hidden name=action value="show" />
				<input style="width:100px" type="submit" value="Zurück" />
				</form>
				<br><br>
			</TD>
			<TD WIDTH=50></TD>
		</TR>
		<TR>
			<TD></TD>
			<TD colspan=3>
			<br><hr><br>
			</TD>
			<TD></TD>
		</TR>
		</TABLE>	
	<?php		
		htmlfooter();
	}		

// edit -->
	if ( $action == 'edit' )
	{
		$text = ereg_replace('<br>', "\n", $news[$nr]);
		htmlhead('on');
	?>
		<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
		<TR>
			<TD colspan=5><br><br></TD>
		</TR>
		<TR>
			<TD WIDTH=50></TD>
			<TD WIDTH=500 valign=top>
				<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
				<textarea style="width:500px;height:150px" wrap=PHYSICAL name="text"><?=$text ?></textarea> 
			</TD>
			<TD WIDTH=40></TD>	
			<TD WIDTH=110 align=right valign=middle>
				<input type=hidden name=action value="save" />
				<input type=hidden name=nr value="<?=$nr ?>" />
				<input style="width:100px" type="submit" value="Speichern" />
				</form>
				<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
				<input type=hidden name=action value="show" />
				<input style="width:100px" type="submit" value="Zurück" />
				</form>
				<br><br>
			</TD>
			<TD WIDTH=50></TD>
		</TR>
		<TR>
			<TD></TD>
			<TD colspan=3>
			<br><hr><br>
			</TD>
			<TD></TD>
		</TR>
		</TABLE>	
	<?php
		htmlfooter();
	}
	
// move -->
	if ( $action == 'move' )
	{
		if ( $go == 'down' ) 
		{	
			if ( $nr == '0' ){ $go = $nr; }
			
			elseif ( $nr == '1' ){ $go = '0'; }
			
			else { $go = $nr - 1; }
		}
		
		if ( $go == 'up' ) 
		{	
			$go = $nr + 1;
			if (empty($news[$go])) { $go = $nr; }
		}
		
		$temp 				= $news[$nr];
		$news[$nr]		= $news[$go];
		$news[$go] 		= $temp;
		
		save_news();
	}		

// delete -->
	if ( $action == 'del' )
	{
		unset($news[$nr]);
		save_news();
	}


// save -->
	if ( $action == 'save' || $save )
	{
		$text 	= trim($text);
		if (!empty($text))
		{ 	
			$text = ereg_replace("\\\'", "&#39;", $text);		// make the quotes visible ' --> &#039;
			$text = ereg_replace('\\\"', '"', $text); 			// remove escaping from doublequotes  \"
			$text = ereg_replace("\n", '<br>', $text); 			// linefeed / breakline ...

			($nr =='new')? $news[] = $text : $news[$nr] = $text;

			save_news();
		}
		header("Location: ".$_SERVER['PHP_SELF']."?action=show"); 	// Stop the reload problem 
	}	

// show -->
	if ( $action == 'show' )
	{
		htmlhead('on');
	?>
		<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
		<TR>
			<TD colspan=7><br></TD>
		</TR>
	<?php
		if (!empty($news))
		{
			foreach ($news as $nr => $text ) 
			{
				?>

				<TR>
				<TD WIDTH=40></TD>
				<TD WIDTH=25 align=left valign=middle>
				<br>
					<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
					<input type=hidden name=action value="move" />
					<input type=hidden name=nr value="<?=$nr ?>" />
					<input type=hidden name=go value="up" />
					<input style="width:20px" type="submit" value=&uarr; />
					</form>
					<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
					<input type=hidden name=action value="move" />
					<input type=hidden name=nr value="<?=$nr ?>" />
					<input type=hidden name=go value="down" />
					<input style="width:20px" type="submit" value=&darr; />
					</form>
				</TD>
				
				<TD WIDTH=30></TD>
				<TD WIDTH=510 valign=top>
				<br>
				<?=$text ?>	
				<br>
				</TD>
				<TD WIDTH=30></TD>	
				<TD WIDTH=105 align=right valign=middle>
				<br>
					<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
					<input type=hidden name=action value=edit>
					<input type=hidden name=nr value="<?=$nr ?>" />
					<input style="width:100px" type="submit" value="Bearbeiten" />
					</form>
					<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="return check()">
					<input type=hidden name=action value="del" />
					<input type=hidden name=nr value="<?=$nr ?>" />
					<input style="width:100px" type="submit" value="Löschen" />
					</form>
				</TD>
				<TD WIDTH=40></TD>
				</TR>
				<TR>
				<TD></TD>
				<TD colspan=5>
				<br><hr>
				</TD>
				<TD></TD>
				</TR>
				<?php
			}
			?>
			</TABLE>
		<?php
		}
		else print '
			<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
			<TR>
				<TD align="center">
				<br><br><br>
				'.NO_NEWS.'
				<br><br><br><br>
				</TD>
			</TR>
			</TABLE>';
	htmlfooter();
	}
}
?>