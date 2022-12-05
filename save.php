<?php
include 'header.php';
if (isset($_SESSION["server"])){
	$server=$_SESSION["server"];
}
if (isset($_SESSION["user_name"])){
	$user=$_SESSION["user_name"];
}
if (isset($_SESSION["password"])){
	$password=$_SESSION["password"];
}
if (isset($_SESSION["database"])){
	$database = $_SESSION["database"];
}
if (isset($_SESSION["tabel"])){
	$tabel = $_SESSION["tabel"];
}
if (isset($_SESSION["namen"])){
	$names = $_SESSION["namen"];
}

$con= mysqli_connect("$server","$user","$password","$database");
// search primary key	
	$sql1="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tabel' AND COLUMN_KEY ='PRI'";
	$result1=mysqli_query($con,$sql1);
	$row = mysqli_fetch_assoc( $result1 );
	$pri = $row['COLUMN_NAME'];

$id = $_GET['id'];
// add new
if($_POST['type']==1){
	$sql = 'INSERT INTO `'.$tabel.'` ( ';
	$total =  count($names);
	$total1 = $total -1 ;
	for ($i=1; $i < $total; $i++){
		if ($i == $total1){
			$sql .= ' `'.$names[$i].'`)';
		}else{
			$sql .= ' `'.$names[$i].'`,';
		}
	}
	$sql .= ' VALUES (';
	for ($i=1; $i < $total; $i++){
		if ($i == $total1){
			$sql .= ' "'.$_POST["$names[$i]"].'")';
		}else{
			$sql .= ' "'.$_POST["$names[$i]"].'",';
		}
	}	
	if (mysqli_query($con, $sql)) {
		echo '<script>alert("Database is geupdate")</script>';
	}else {
		echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}
	mysqli_close($con);
	header('location:result.php?tabel='.$tabel.'');		
}

// update
if($_POST['type']==2){
	$sql = 'update '.$tabel.' SET ';
	$total =  count($names);
	$total1 = $total -1 ;
	for ($i=0; $i < $total; $i++){
		if ($i == $total1){
			$sql .= ' `'.$names[$i].'` ="'.$_POST["$names[$i]"].'"';
		}else{
			$sql .= ' `'.$names[$i].'` ="'.$_POST["$names[$i]"].'",';
		}
	}
	$sql .= ' WHERE '.$pri.'='.$id.'';

	if (mysqli_query($con, $sql)) {
		echo '<script>alert("Database is geupdate")</script>';
	}else {
		echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}
	mysqli_close($con);
	header('location:result.php?tabel='.$tabel.'');	
}

// delete
if($_POST['type']==3){
	$sql = "DELETE FROM $tabel WHERE $pri=$id ";
	if (mysqli_query($con, $sql)) {
		echo $id;
	}else {
		echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}
	mysqli_close($con);
//	header('location:result.php?tabel='.$tabel.'');
}
?>
