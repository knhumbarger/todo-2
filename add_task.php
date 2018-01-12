<!doctype html>
<html>
<head> 
<link rel="stylesheet" type="text/css" href="template.css">
<h1>To Do</h1>
</head>
<body>
<div class="navbar">
<a href="main.php">Main Page</a>
<a href="main.php?status=pending">Pending Tasks</a>
<a href="main.php?status=started">Started Tasks</a>
<a href="main.php?status=completed">Completed Tasks</a>
<a href="main.php?status=late">Late Tasks</a>
</div>
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
	
	if(!$task = new task(null, $name, $descr, $priority, $status, $date)){
		print "Unable to create new object of task class.";
	}
	if(!$task->add_task()){
		print "Unable to add new task to task table in todo database.";
	}
	
	header('Location: main.php');
	exit;
	
?>
</html>