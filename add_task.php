<html>
<?php
	$name = '';
	$descr = '';
	$priority = '';
	$status = '';
	$date = '';
	
	if(isset($_POST['name'])){
		$name = $_POST['name'];
	}
	if(isset($_POST['descr'])){
		$descr = $_POST['descr'];
	};
	if(isset($_POST['priority'])){
		$priority = $_POST['priority'];
	};
	if(isset($_POST['status'])){
		$status = $_POST['status'];
	};
	if(isset($_POST['due_date'])){
		$date = $_POST['due_date'];
	};
	//echo $name;
	//echo $descr;
	//echo $priority;
	//echo $status;
	//echo $date;
	
	$db = new mysqli("localhost", "root", "pass1234", "todo");
	//echo $db;
	$statement = "INSERT INTO task(name, descr, priority, status, due_date) VALUES('".$name."', '".$descr."', '".$priority."', '".$status."', '".$date."');";
	echo $statement;
	$r1 = $db->query($statement);
	echo $r1;
	print $r1;
	
	echo "<form action='main.php' method='post'>";
	echo "<input type='submit'>";
	echo "</form>";
?>
</html>