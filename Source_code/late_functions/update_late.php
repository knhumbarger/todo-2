<?php
	require_once("class.task.php");
		
	function update_late($id, $name, $descr, $priority, $status, $date){
		if(!$task = new task($id, $name, $descr, $priority, $status, $date)){
			print "Unable to create new object of class task.";
			return 0;
		}
		if (!$task->mark_late()){
			print "Unable to update task status to late.";
			return 0;
		}
		return 1;
	}
?>