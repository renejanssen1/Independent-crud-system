<?php
include 'header.php';

print "<tr><td valign='top' height='615'>\n"; 
print "<div id='content'>\n";
print "<DIV id=mainmenu_centerbox>\n";
if (isset($_SESSION["server"])){
	$server=$_SESSION["server"];
}
if (isset($_SESSION["user_name"])){
	$user=$_SESSION["user_name"];
}
if (isset($_SESSION["password"])){
	$password=$_SESSION["password"];
$con = mysqli_connect("$server","$user","$password");
$oud = 'test';
$sql="SELECT TABLE_SCHEMA FROM information_schema.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
$result=mysqli_query($con,$sql);
?>
<table align="center" class="table2">
<tr><td>
<label for "database">Kies een database:</label>

<form method='post' action='' id='myform'>
<select name='database' onchange='submitForm();'>
<option value='---' <?php if(isset($_POST['database']) && $_POST['database'] == '---'){ echo "selected"; } ?> >---</option> 
<?php
while ( $tables = $result->fetch_assoc()){
	$data = $tables['TABLE_SCHEMA'];
	if ($data != performance_schema){
	if ($data != mysql){
	if ($oud != $data){
		echo '<option value="'.$data.'"';
		if(isset($_POST['database']) && $_POST['database'] == $data){
			echo 'selected';
		}
		echo '>'.$data.'</option>';

		$oud = $data;
	}
	}}
}
echo '</select></form></td></tr>';
//$data = '';
//$result->free();
?>
 
<!-- Script --> 
<script type='text/javascript'> 
function submitForm(){ 
  // Call submit() method on <form id='myform'>
  document.getElementById('myform').submit(); 
} 
</script>

<?php

$_SESSION['db'] = $_POST['database'];
$db = $_POST['database'];

if(isset($db)){
	$sql="SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$db'";
	$result=mysqli_query($con,$sql);
?>
<tr><td>
<label for "tabel">Kies een tabel:</label>

<form method='post' action='' id='form'>
<select name='tabel' onchange='submit();'>
<option value='---' <?php if(isset($_POST['tabel']) && $_POST['tabel'] == '---'){ echo "selected"; } ?> >---</option> 
<?php

while ( $tables = $result->fetch_assoc()){
	$data = $tables['TABLE_NAME'];
		echo '<option value="'.$db.':'.$data.'"';
		if(isset($_POST['tabel']) && $_POST['tabel'] == $data){
			echo 'selected';
		}
		echo '>'.$data.'</option>';
}
echo '</select></form></td></tr>';
$data = '';
$result->free();

?>
 <script type='text/javascript'> 
function submit(){ 
  // Call submit() method on <form id='myform1'>
  document.getElementById('form').submit(); 
</script>
<?php
echo '</div></div><table>';
}
$tabel = $_POST['tabel'];
}
if (isset($tabel)){
	header("Location: result.php?database=$tabel");
}
echo "</td></tr>\n"; 

echo "</table>\n";
echo "</body>\n"; 
echo "</html>\n"; 
?>
