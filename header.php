<?php
session_cache_limiter ('private, must-revalidate'); 
session_start();

if (isset($_GET['log_off'])){
	session_unset(); 
	session_destroy();
	session_write_close();
	session_start();
}

$user["user_name"]="";
if (isset($_SESSION["user_name"])){
	$user["user_name"]=$_SESSION["user_name"];
}

if (isset($_POST["username"]) && isset($_POST["password"])  && isset($_POST["server"])){
	$username=$_POST["username"];
	$password= $_POST["password"];
	$server=$_POST["server"];
	$con = mysqli_connect("$server","$username","$password");
	if(mysqli_connect_error()){
		$fault=true;
    }else{
		$_SESSION["user_name"] = $_POST["username"];
		$_SESSION["password"] = $_POST["password"];
		$_SESSION["server"] = $_POST["server"];
		header("Location: tabel.php");
	}
}

print	'<!DOCTYPE HTML PUBLIC "-//W3C//DTDHTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
echo "<html>\r\n";
print "<head>\r\n";
print "<meta http-equiv='content-type' content='text/html; charset=utf-8'>\r\n";
print "<title>Meterstanden</title>\r\n";
echo "<link href='dbase.css' rel='stylesheet' type='text/css'>\r\n";
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
echo '</head>';


echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" height=\"100%\">\n"; 
echo "	<tr>\n";
 
if (!$user["user_name"]){
	print "<td bgcolor='#33F1FF' valign='center' height='40' ><a href='index.php'><span class=style1><center>Inloggen</center></span></a>\n";
} else{
	print "<td bgcolor='#33F1FF' valign='center' height='40' ><a href='index.php?log_off=1'><span class=style1><center>Uitloggen [".$_SESSION["user_name"]."]</center></span></a>\n";
}
echo "		</td>\n"; 
echo "	</tr>\n"; 
?>