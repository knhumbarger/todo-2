<!doctype html>
<html>
<head> 
<link rel="stylesheet" type="text/css" href="CSS/template.css">
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
<br>
<br>
<?php
	require_once('class.mySQLDAO.php');
	require_once('late_functions/check_late.php');
	
	$status='';
	
	//check for get method status variable
	//this is used to filter the tasks by status when
	//the user clicks on either one of the "counts" on the 
	//right side of the page or a link on the navbar
	if(isset($_GET['status'])){
		$status = $_GET['status'];
	}
	
	if(!$mySQL = new mySQLDAO()){
		echo "Error: could not establish connection to the mySQL.";
	}
	if(!$mySQL->create_DB()){
		echo "Error: could not establish connection to the todo database.";
	}
	if(!$mySQL->create_tables()){
		echo "Error: could not create one or more tables in the todo database.";
	}
	
	echo '<div class="content">';
	
	if($status == ''){
		$statement = "SELECT * FROM task";
	}
	else{
		$statement = "SELECT * FROM task WHERE status='".$status."';";
	}
	$r4 = $mySQL->execute_query($statement);
	
	//headings
	echo '<table>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Name</th>';
	echo '<th>Description</th>';
	echo '<th>Priority</th>';
	echo '<th>Status</th>';
	echo '<th>Due Date</th>';
	echo '</tr>';
	
	//create tasks table on main page
	while ($row = $r4->fetch_array()){
		
		//check if task is now late and update if so
		if(check_late($row["id"], $row["name"], $row["descr"], $row["priority"], $row["status"], $row["due_date"])){
			$row["status"] = "late";
		}
		
		//find default value for priority drop-down
		$priority_options = '';
		if($row["priority"] == 'high'){
			$priority_options = '<Select name="priority">
		<option value="high" selected="selected">High</option>
		<option value="medium">Medium</option>
		<option value="low">Low</option>
		</select>';
		}
		else if($row["priority"] == 'medium'){
			$priority_options = '<Select name="priority">
		<option value="high">High</option>
		<option value="medium" selected="selected">Medium</option>
		<option value="low">Low</option>
		</select>';
		}
		else{
			$priority_options = '<Select name="priority">
		<option value="high">High</option>
		<option value="medium">Medium</option>
		<option value="low" selected="selected">Low</option>
		</select>';
		}
		
		$status_options = '';
		//find default value for status drop-down
		if($row["status"]=='pending'){
			$status_options = '<Select name="status">
			<option value="pending" selected="selected">Pending</option>
			<option value="started">Started</option>
			<option value="completed">Completed</option>
			<option value="late">Late</option>
			</select>';
		}
		
		else if($row["status"]=='started'){
			$status_options = '<Select name="status">
			<option value="pending">Pending</option>
			<option value="started" selected="selected">Started</option>
			<option value="completed">Completed</option>
			<option value="late">Late</option>
			</select>';
		}
		
		else if($row["status"]=='completed'){
			$status_options = '<Select name="status">
			<option value="pending">Pending</option>
			<option value="started">Started</option>
			<option value="completed" selected="selected">Completed</option>
			<option value="late">Late</option>
			</select>';
		}
		
		else{
			$status_options = '<Select name="status">
			<option value="pending">Pending</option>
			<option value="started">Started</option>
			<option value="completed">Completed</option>
			<option value="late" selected="selected">Late</option>
			</select>';
		}
		
		//display the table row
		echo '<tr>';
		echo '<form action="delete_task.php" method="post">';
		echo '<td><input type="text" name="id" value="'.$row["id"].'" readonly></td>';
		echo '<td><input type="text" name="name" value="'.$row["name"].'"></td>';
		echo '<td><input type="text" name="descr" value="'.$row["descr"].'"></td>';
		echo '<td>'.$priority_options.'</td>';
		echo '<td>'.$status_options.'</td>';
		echo '<td><input type="date" name="due_date" value="'.$row["due_date"].'">';
		echo '<input type="submit" name="button" value="Delete" id="btn">';
		echo '<input type="submit" name="button" value="Update" id="btn"></td>';
		echo '</form>';
		echo '</tr>';
	}
	
	echo '</table>';
	echo '</div>';
	
	try{
		echo '<div class="countbar">';
		echo '<br>';
		$r5 = $mySQL->execute_query("SELECT COUNT(*) FROM task;");
		$count_total = $r5->fetch_row();
		echo 'Total tasks: <a href="main.php">'.$count_total[0].'</a><br><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for all tasks.";
	}
	
	try{
		$r6 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'pending';");
		$pending_total = $r6->fetch_row();
		echo 'Total pending tasks: <a href="main.php?status=pending">'.$pending_total[0].'</a><br><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for pending tasks.";
	}
	
	try{
		$r7 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'started';");
		$started_total = $r7->fetch_row();
		echo 'Total started tasks: <a href="main.php?status=started">'.$started_total[0].'</a><br><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for started tasks.";
	}
	
	try{
		$r8 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'completed';");
		$completed_total = $r8->fetch_row();
		echo 'Total completed tasks: <a href="main.php?status=completed">'.$completed_total[0].'</a><br><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for completed tasks.";
	}
	
	try{
		$r9 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status='late';");
		$late_total = $r9->fetch_row();
		echo 'Total late tasks: <a href="main.php?status=late">'.$late_total[0].'</a><br><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for late tasks.";
	}
	
	//add task 
	echo '</div>';
	echo '<div class="content">';
	echo '<h3>Add new task</h3>';
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
	echo '<input type="submit" id="btn">';
	echo '</form>';
	echo '<br>';
	
	echo '</div>';
	
?>
	
</body>
</html>