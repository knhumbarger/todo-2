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
	$id = '';
	$name = '';
	$descr = '';
	$priority = '';
	$status = '';
	$date = '';
	$button='';
	
	if(isset($_POST['id'])){
		$id = $_POST['id'];
	}
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
	if(isset($_POST['button'])){
		$button = $_POST['button'];
	}

	$task = new task($id, $name, $descr, $priority, $status, $date);
	if($button == 'delete'){
		$task->delete_task();
	}
	else{
		$task->update_task();
	}
	
	header('Location: main.php');
	exit;
	
?>
</body>
</html>