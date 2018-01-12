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
<br>
<br>
<?php
	require_once('class.mySQLDAO.php');
	require_once('check_late.php');
	
	$status='';
	
	//check for get method status variable
	//this is used to filter the tasks by status when
	//the user clicks on either one of the "counts" on the 
	//right side of the page or a link on the navbar
	if(isset($_GET['status'])){
		$status = $_GET['status'];
	}
	
	if(!$mySQL = new mySQLDAO("localhost", "root", "pass1234")){
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
	echo '<form>';
	echo '<input type="text" name="id" value="ID" style="font-weight:bold;">';
	echo '<input type="text" name="name" value="name" style="font-weight:bold;">';
	echo '<input type="text" name="descr" value="description" style="font-weight:bold;">';
	echo '<input type="text" name="priority" value="priority" style="font-weight:bold;">';
	echo '<input type="text" name="status" value="status" style="font-weight:bold;">';
	echo '<input type="text" name="due_date" value="due date" style="font-weight:bold;">';
	echo '</form>';
	
	//create tasks table on main page
	while ($row = $r4->fetch_array()){
		
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
		echo '<form action="delete_task.php" method="post">';
		echo '<input type="text" name="id" value="'.$row["id"].'" readonly>';
		echo '<input type="text" name="name" value="'.$row["name"].'">';
		echo '<input type="text" name="descr" value="'.$row["descr"].'">';
		echo $priority_options;
		echo $status_options;
		echo '<input type="text" name="due_date" value="'.$row["due_date"].'">';
		echo '<input type="submit" name="button" value="Delete" id="btn">';
		echo '<input type="submit" name="button" value="Update" id="btn">';
		echo '</form>';
	}
	
	//add task 
	echo '<form action="add_task.php" method="post">';
	echo "Add new task:		";
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
	
	
	echo '</div>';

	try{
		echo '<div class="countbar">';
		$r5 = $mySQL->execute_query("SELECT COUNT(*) FROM task;");
		$count_total = $r5->fetch_row();
		echo 'Total tasks: <a href="main.php">'.$count_total[0].'</a><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for all tasks.";
	}
	
	try{
		$r6 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'pending';");
		$pending_total = $r6->fetch_row();
		echo 'Total pending tasks: <a href="main.php?status=pending">'.$pending_total[0].'</a><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for pending tasks.";
	}
	
	try{
		$r7 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'started';");
		$started_total = $r7->fetch_row();
		echo 'Total started tasks: <a href="main.php?status=started">'.$started_total[0].'</a><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for started tasks.";
	}
	
	try{
		$r8 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status = 'completed';");
		$completed_total = $r8->fetch_row();
		echo 'Total completed tasks: <a href="main.php?status=completed">'.$completed_total[0].'</a><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for completed tasks.";
	}
	
	try{
		$r9 = $mySQL->execute_query("SELECT COUNT(*) FROM task WHERE status='late';");
		$late_total = $r9->fetch_row();
		echo 'Total late tasks: <a href="main.php?status=late">'.$late_total[0].'</a><br>';
	} catch (Exception $e){
		echo "Unable to retrieve the count for late tasks.";
	}

	echo '</div>';
?>
</div>
</body>
</html>