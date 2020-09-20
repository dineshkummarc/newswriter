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

@(include('config.php')) OR die ('<b>config.php not found!</b>');

$links 		= 'Aktuelle News';
$news 		= get_news();
krsort($news);

htmlhead($links);

	if (!empty($news))
	{
		print '	<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
			<TR>
				<TD colspan=7><br></TD>
			</TR>
		';
		
		foreach ($news as $text ) 
		{
			?>
			
			<TR>
			<TD WIDTH=40></TD>
			<TD WIDTH=670 valign=top>
			<br>
			<?=$text ?>	
			<br>
			</TD>
			<TD WIDTH=40></TD>
			</TR>

			<TR>
			<TD></TD>
			<TD>
			<br><hr>
			</TD>
			<TD></TD>
			</TR>
			<?php
		}
		print '</TABLE>';
	}
	else print '
		<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#FFFFFF>
		<TR>
			<TD>
			<br>
			<center>
			'.NO_NEWS.'
			</TD>
		</TR>
		</TABLE>';
		
htmlfooter('&para;'); 		// If you don't like to have a link to the adminarea,
													// just change htmlfooter('&para;'); to htmlfooter();
?>