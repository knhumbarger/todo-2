<html>
<?php

	require_once("class.task.php");
	
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
	
	$task = new task(null, $name, $descr, $priority, $status, $date);
	$task->add_task();
	
	echo "<form action='main.php' method='post'>";
	echo "<input type='submit'>";
	echo "</form>";
?>
</html>