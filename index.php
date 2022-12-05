<?php
$fault=false;
$head_text="main_login";
include_once("header.php"); 
echo '<td valign="top" height="600">';
print "<div id='content'>\n";
print "<DIV id=mainmenu_centerbox>\n";
if ($fault==true){
	echo '<div class="center"><font color="red"><b>Geen geldige gebruikersnaam of wachtwoord opgegeven!</b></font></div>';
}
$path_tmp='index.php';

print '<form name="form1" method="post" action="'.$path_tmp.'">';
	print '<table align="center" class="table2">';
	print '<th colspan="2" class="top1">Inloggen</th>';
	print '<tr><td>Server:</td><td><input name="server" type="text" size="20" maxlength="25"></td></tr>';
	print '<tr><td>Gebruikersnaam:</td><td><input name="username" type="text" size="20" maxlength="25"></td></tr>';
	print '<tr><td>Wachtwoord:</td><td><input name="password" type="password" size="20" maxlength="25"></td></tr>';
	print '<tr><td><br></td><td><input type="submit" name="submit" value=Login></td></tr>';
	print '</table>';
print '</form>';
print '</div>';
echo "</td></tr>\n"; 
echo "</table>\n";
echo "</body>\n"; 
echo "</html>\n"; 
?>