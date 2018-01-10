<!doctype html>
<html>
<head> 

<h1>To Do</h1>

</head>
<body>
<?php
	$db = new mysqli("localhost", "root", "pass1234");

	$r1 = $db->query("CREATE DATABASE IF NOT EXISTS todo;");
	
	$r2 = $db->query("USE todo;");
	
	$r3 = $db->query("CREATE TABLE task(id INTEGER AUTO_INCREMENT, name VARCHAR(15), descr VARCHAR(255), priority ENUM('high', 'medium', 'low'), status ENUM('pending', 'started', 'completed', 'late'), due_date DATE, PRIMARY KEY(id));");
	
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
	
	
	$r4 = $db->query("SELECT * FROM task");
	
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
		echo '<input type="text" name="id" value='.$row["id"].'>';
		echo '<input type="text" name="name" value='.$row["name"].'>';
		echo '<input type="text" name="descr" value='.$row["descr"].'>';
		echo '<input type="text" name="priority" value='.$row["priority"].'>';
		echo '<input type="text" name="status" value='.$row["status"].'>';
		echo '<input type="text" name="due_date" value='.$row["due_date"].'>';
		echo '<input type="submit" value="delete">';
		echo '</form>';
	}
	
	$r5 = $db->query("SELECT COUNT(*) FROM task");
	$count_total = $r5->fetch_row();
	echo 'Total tasks: '.$count_total[0].'<br>';
	
	$r6 = $db->query("SELECT COUNT(*) FROM task WHERE status = 'pending'");
	$pending_total = $r5->fetch_row();
	echo 'Total pending tasks: '.$pending_total[0].'<br>';
	
	$r7 = $db->query("SELECT COUNT(*) FROM task WHERE status = 'started'");
	$started_total = $r7->fetch_row();
	echo 'Total started tasks: '.$started_total[0].'<br>';
	
	$r8 = $db->query("SELECT COUNT(*) FROM task WHERE status = 'completed'");
	$completed_total = $r8->fetch_row();
	echo 'Total completed tasks: '.$completed_total[0].'<br>';
	
	$r9 = $db->query("SELECT COUNT(*) FROM task WHERE status='late'");
	$late_total = $r9->fetch_row();
	echo 'Total late tasks: '.$late_total[0].'<br>';
	
?>
</body>
</html>