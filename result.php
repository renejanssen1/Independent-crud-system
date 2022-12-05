<?php
include 'header.php';

echo '<td valign="top" height="620">'; 
print '<div id="content">';
print '<DIV id=mainmenu_centerbox>';
if (isset($_SESSION["server"])){
	$server=$_SESSION["server"];
}
if (isset($_SESSION["user_name"])){
	$user=$_SESSION["user_name"];
}
if (isset($_SESSION["password"])){
	$password=$_SESSION["password"];
}
$samen = $_GET['database'];
if (isset($samen) OR isset($_GET['database'])){
$_SESSION["database"] = $_GET['database'];}
if (isset($_SESSION["database"])){
	$database=$_SESSION["database"];
}
$_SESSION["tabel"]=$_GET['tabel'];
if (isset($_SESSION["tabel"])){
	$tabel=$_SESSION["tabel"];
}
if (isset($samen)){	
	$test = explode(":", $samen);
	$_SESSION["database"]=$test[0];
	$_SESSION["tabel"]=$test[1];
	$samen='';
	$database = $_SESSION["database"];
	$tabel = $_SESSION["tabel"];
}
// column names in array
	$con= mysqli_connect("$server","$user","$password","$database");
	$sql="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tabel'";
	$result=mysqli_query($con,$sql);
	$rows = mysqli_num_rows($result);
	$data = array();
	$rows1= $rows + 1;
	$i=0;
// search primary key	
	$sql1="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tabel' AND COLUMN_KEY ='PRI'";
	$result1=mysqli_query($con,$sql1);
	$row = mysqli_fetch_assoc( $result1 );
	$pri = $row['COLUMN_NAME'];


// colomn names
echo "<table align='center' class='autowidth'>\r\n";
echo "<tr><th colspan=$rows align='center' class='top2'>Database <i>$database</i>  Tabel <i>$tabel</i></th>\r\n";
echo '<th class="top3"><a href="#add" data-toggle="modal"><img src="./img/add.png" alt="add" width="15" height="15"></a></th></tr>';
	while ( $tables = $result->fetch_assoc()){
		$data[] = $tables['COLUMN_NAME'];
		echo "<td class='z'>$data[$i]</td>\r\n";
		$i++;
	}
	echo "<td class='z'> Edit</td>\r\n";
$names = $data;
$_SESSION['namen'] = $names;

if (isset($tabel)){
$sql="select * from $tabel";
$result = mysqli_query($con,$sql);
$num_rows = mysqli_num_rows($result);
$total=$num_rows;
$max_on_page = 20;
$viewpage = 1;
$num_pages = ceil($num_rows / $max_on_page);
$page = $_GET['page'];
if (!isset($_GET['page'])) {
    $page = 1;
}
$begin = $page - $viewpage;
if ($begin < 1) {
    $begin = 1;
}
$end = $page + $viewpage;
if ($end > $num_pages) {
    $end = $num_pages;
}
$vorige = $page - 1;
$volgende = $page + 1;
$start = $max_on_page * $page - $max_on_page;
$result = mysqli_query($con,"SELECT * FROM $tabel ORDER BY `$pri` DESC LIMIT ".$start.", ".$max_on_page."") or die(mysqli_error());
$num_rows = mysqli_num_rows($result);
while($row = mysqli_fetch_array( $result )){
	$i=0;
		echo "</tr><tr>\r\n";
		for ($j=0; $j < $rows; $j++){
			echo '<td>'.$row["$data[$j]"].' </td>';
			$i++;
		}
		echo '<td ><a href="#edit'.$row["$data[0]"].'" data-toggle="modal"><img src="./img/edit.png" alt="edit" width="15" height="15"></a>'; 
		echo '<a href="#delete'.$row["$data[0]"].'" data-toggle="modal"><img src="./img/delete.png" alt="delete" width="15" height="15"></a>';
?>
<!-- Add Modal HTML -->
<div class="modal fade" id="add" >
	<div class="modal-dialog">
		<form method="POST" action="save.php">
		<table class="table2">
				<tr><th colspan="2" align="center" class="top1">Add <?php echo $tabel;?></th></tr>
				<?php
				for ($i=1; $i < $rows; $i++){
					echo '<tr><td font-size="12px">'.$names[$i].'</td><td><input name="'.$names[$i].'" value=""</td></tr>';
				}
				?>
				<tr>
					<td><input type="hidden" value="1" name="type"></td>
					<td><input type="button"  name="submit" data-dismiss="modal" value="Cancel">
					<button type="submit"  id="update">Add</button></td>
				</tr>
		</table>
		</form>
	</div>
</div>	
<!-- Edit Modal HTML -->
<div class="modal fade" id="edit<?php echo $row["$data[0]"]; ?>" ">
	<div class="modal-dialog">
	<?php
		$edit=mysqli_query($con,"select * from $tabel where `$pri`='".$row["$data[0]"]."'");
		$erow=mysqli_fetch_array($edit);
	?>	
		<form method="POST" action="save.php?id=<?php echo $erow["$data[0]"]; ?>">
		<table class="table2">
				<tr><th colspan="2" align="center" class="top1">Edit <?php echo $tabel;?></th></tr>
					 <!-- type = "hidden" -->
					<input type = "hidden" name="server" value="<?php echo $server; ?>">
					<input type = "hidden" name="user" value="<?php echo $user; ?>">
					<input type = "hidden" name="password" value="<?php echo $password; ?>">
					<input type = "hidden" name="database" value="<?php echo $database; ?>">
					<input type = "hidden" name="tabel" value="<?php echo $tabel; ?>">
					<?php
						$i = 0;
						$_SESSION["id"] = $erow["$data[0]"];
						for ($j=0; $j < $rows; $j++){
							echo '<tr><td font-size="12px">'.$names[$i].'</td><td><input name="'.$names[$i].'" value="'.$erow["$data[$j]"].'"</td></tr>';
							$i++;
						}
					?>

				<tr>
					<td><input type="hidden" value="2" name="type"></td>
					<td><input type="button"  name="submit" data-dismiss="modal" value="Cancel">
					<button type="submit"  id="update">Update</button></td>
				</tr>
		</table>
		</form>
	</div>
</div>	
<!-- Delete Modal HTML -->
<div class="modal fade" id="delete<?php echo $row["$data[0]"]; ?>" ">
	<div class="modal-dialog">
		<form method="POST" action="save.php?id=<?php echo $row["$data[0]"]; ?>">
		<table class="table2">
				<tr><th colspan="2" align="center" class="top1">Delete Idnr: <?php echo $row["$data[0]"];?></th></tr>
				<tr><td colspan="2" align="center"> Weet je het zeker?</td></tr>				
				<tr>
					<td><input type="hidden" value="3" name="type"></td>
					<td><input type="button" name="submit" data-dismiss="modal" value="Cancel">
					<button type="submit" class="btn btn-danger" id="delete">Delete</button></td>
				</tr>			
		</table>				
		</form>
		<?php
		}
		?>		
	</div>
</div>
	
	
</td></td></tr></table>
<?php
$uitvoer = 0;

echo "<table class='table3'>\n";
echo "<tr>";
echo "<td width =120 align=left class=top4>Pagina ".$page." van ".$num_pages."</td>";
echo "<td width =220 class=top>Gevonden items: $total</td>";
if ($num_pages==1){
	echo '<b><td width =20 align=center class=top>'.$page.' </td></b>';
}elseif ($uitvoer==0) {
	echo '<td class=top><a href="result.php?page=1&start=',$start,'&tabel='.$tabel.'">eerste</a>';
	for ($i = $begin; $i <= $end; $i++) {
		if ($i == $page) {
			echo '<b><td width =30 align=center class=top>'.$page.' </td></b>';
		}else {
			echo '<td width=30 align=center class=top><a href="result.php?page='.$i.'&start=',$start,'&tabel='.$tabel.'">'.$i.' </a></td> ';
		}
	}
	echo '<td align=right class=top5><a href="result.php?page='.$num_pages.'&start=',$start,'&tabel='.$tabel.'"> laatste</a></td>';
}
Print "</tr>";
echo '</table>';

echo '<center><button><a href="tabel.php">Nieuwe Tabel</a></button></center>';
print '</div>';
echo '</td></tr>'; 

}
echo "</table>\n";
echo "</body>\n"; 
echo "</html>\n"; 
?>