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

	if(!$task = new task($id, $name, $descr, $priority, $status, $date)){
		print "Unable to create new object of class task.";
	}
	
	if($button == 'Delete'){
		if(!$task->delete_task()){
			print "Unable to delete task from task table.";
			echo "Unable to delete task from task table.";
		}
	}
	else{
		if(!$task->update_task()){
			print "Unable to update task in task table.";
		}
	}
	
	header('Location: main.php');
	exit;
	
?>
</body>
</html>