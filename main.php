<!doctype html>
<html>
<head> 

<h1>To Do</h1>

</head>
<body>
<?php
	require_once('class.mySQLDAO.php');
	
	$status='';
	
	//check for get method status variable
	if(isset($_GET['status'])){
		$status = $_GET['status'];
	}
	
	echo "STATUS ".$status;
	
	$mySQL = new mySQLDAO("localhost", "root", "pass1234");
	$mySQL->create_DB();
	$mySQL->create_tables();
	
	//add task 
	echo '<form action="add_task.php" method="post">';
	echo '<input type="text" name="name" value="insert name">';
	echo '<input type="text" name="descr" value="insert description">';
	echo '<Select name="priority">
		<option value="high">High</option>
		<option value="medium">Medium</option>
		<option value="low">Low</option>
		</select>';
	echo '<Select name="status">
		<option value="pending">Pending</option>
		<option value="started">Started</option>
		<option value="completed">Completed</option>
		<option value="late">Late</option>
		</select>';
	echo '<input type="date" name="due_date" value="due date">';
	echo '<input type="submit">';
	echo '</form>';
	
	if($status == ''){
		$statement = "SELECT * FROM task";
	}
	else{
		$statement = "SELECT * FROM task WHERE status='".$status."';";
	}
	$r4 = $mySQL->execute_query($statement);
	
	//headings
	echo '<form>';
	echo '<input type="text" name="id" value="ID" style="font-weight:bold;">';
	echo '<input type="text" name="name" value="name" style="font-weight:bold;">';
	echo '<input type="text" name="descr" value="description" style="font-weight:bold;">';
	echo '<input type="text" name="priority" value="priority" style="font-weight:bold;">';
	echo '<input type="text" name="status" value="status" style="font-weight:bold;">';
	echo '<input type="text" name="due_date" value="due date" style="font-weight:bold;">';
	echo '</form>';
	while ($row = $r4->fetch_array()){
		echo '<form action="delete_task.php" method="post">';
		echo '<input type="text" name="id" value="'.$row["id"].'">';
		echo '<input type="text" name="name" value="'.$row["name"].'">';
		echo '<input type="text" name="descr" value="'.$row["descr"].'">';
		echo '<input type="text" name="priority" value="'.$row["priority"].'">';
		echo '<input type="text" name="status" value="'.$row["status"].'">';
		echo '<input type="text" name="due_date" value="'.$row["due_date"].'">';
		echo '<input type="submit" value="delete">';
		echo '</form>';
	}
	$r5 = $mySQL->execute_query("SELECT COUNT(*) FROM task;");
	$count_total = $r5->fetch_row();
	echo 'Total tasks: <a href="main.php">'.$count_total[0].'</a><br>';
	
	$r6 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'pending';");
	$pending_total = $r6->fetch_row();
	echo 'Total pending tasks: <a href="main.php?status=pending">'.$pending_total[0].'</a><br>';
	
	$r7 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'started';");
	$started_total = $r7->fetch_row();
	echo 'Total started tasks: <a href="main.php?status=started">'.$started_total[0].'</a><br>';
	
	$r8 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'completed';");
	$completed_total = $r8->fetch_row();
	echo 'Total completed tasks: <a href="main.php?status=completed">'.$completed_total[0].'</a><br>';
	
	$r9 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status='late';");
	$late_total = $r9->fetch_row();
	echo 'Total late tasks: <a href="main.php?status=late">'.$late_total[0].'</a><br>';
	
?>
</body>
</html>