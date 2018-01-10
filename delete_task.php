<?php
	$id = '';
	
	if(isset($_POST['id'])){
		$id = $_POST['id'];
	}
	
	$db = new mysqli("localhost", "root", "pass1234", "todo");
	//echo $db;
	$statement = "DELETE FROM task WHERE id=".$id.";";
	echo $statement;
	$r1 = $db->query($statement);
	echo $r1;
	print $r1;
	
	echo "<form action='main.php' method='post'>";
	echo "<input type='submit'>";
	echo "</form>";
?>