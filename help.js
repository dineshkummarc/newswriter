function help() { 
popup = window.open("about:blank","_blank","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=300,height=250,left=0,top=0"); 
popup.document.write('<html><head><title>Newswriter Help</title>');
popup.document.write('<link rel="stylesheet" href="style.css" type="text/css">');
popup.document.write('</head><body>');
popup.document.write('<h3>Admin Help</h3><br>');
popup.document.write('&#60;b&#62; <b>Bold text</b> &#60;/b&#62;<br><br>');
popup.document.write('&#60;i&#62; <i>Italic text</i> &#60;/i&#62;<br><br>');
popup.document.write('&#60;u&#62; <u>Underlined text</u> &#60;/u&#62;<br><br><br>');
popup.document.write('You can also use every other html-tag,<br>but be sure to have them always closed.<br><br><br>');
popup.document.write('<a href="http://www.asciitable.com/" target="_blank">Ascii-Codes</a> - <a href="http://www.htmlhelp.com/reference/html40/alist.html" target="_blank">html-Reference</a> - <a href="http://newswriter2005.sourceforge.net/" target="_blank">Project</a>');
popup.document.write('</body></html>');
popup.focus();
return true;
}

function check()
{
	input_box=confirm("Sind Sie sicher?");
	if (input_box==true)

	{ 
	// Output when OK is clicked
	return true;
	}

	else
	{
	// Output when Cancel is clicked
	return false;
	}
}