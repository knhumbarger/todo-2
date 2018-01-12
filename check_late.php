<?php
	function check_late($_id, $_name, $_descr, $_priority, $_status, $_date){
		require_once("class.task.php");
		
		//date format: mm-dd-yyyy
		$date = $_date;
		$id = $_id;
		$name = $_name;
		$descr = $_descr;
		$priority = $_priority;
		$status = $_status;
		$date = $_date;
		
		$today = date('m-d-Y');
		
		//task if past due if due date is earlier
		//than today's date
		
		$date = explode('-', $date);
		$today = explode('-', $today);
		
		//if year of the due date is less than year of today
		if($date[2] < $today[2]){
			//late
			update_late();
			return 1;
		}
		//if year of the due date is greater than or equal to
		//year of today
		else{
				//if month of due date is less than month of
				//today
				if ($date[0] < $today[0]){
					//late
					update_late();
					return 1;
				}
				//if month of due date is greater than or equal to
				//month of today and
				else{
					//if day of due date is less than day of 
					//today
					if ($date[1] < $today[1]){
						//late
						update_late();
						return 1;
					}
					else{
						//not late
						return 0;
					}
				}
		}
		
		function update_late(){
			if(!$task = new task($id, $name, $descr, $priority, $status, $date)){
				print "Unable to create new object of class task.";
				return 0;
			}
			if (!task->mark_late()){
				print "Unable to update task status to late.";
				return 0;
			}
			return 1;
		}
	}
?>