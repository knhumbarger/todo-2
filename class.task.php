<?php
	require_once('class.priority.php');
	require_once('class.status.php');
	require_once('class.mySQLDAO.php');
	//class for tasks
	class task{
		private $id = null;
		private $name = '';
		private $descr = '';
		private $priority = '';
		private $status = '';
		private $due_date = '';
		private $mySQL = null;
		
		public function __construct($_id, $_name, $_descr, $_priority, $_status, $_due_date){
			$this->name=$_name;
			$this->id=$_id;
			$this->descr=$_descr;
			$this->priority = new priority($_priority);
			$this->status = new status($_status);
			$this->due_date=$_due_date;
			$this->mySQL = new mySQLDAO("localhost", "root", "pass1234");
			$this->mySQL->connect_db("todo");
		}
		public function add_task(){
			$statement = "INSERT INTO task(name, descr, priority, status, due_date) VALUES('".$this->name."', '".$this->descr."', '".$this->priority->get_pri()."', '".$this->status->get_stat()."', '".$this->due_date."');";
			echo $statement;
			if(!$this->mySQL->execute_query($statement)){
				return 0;
			}
			return 1;
			
		}
		public function delete_task(){
			//$db = new mysqli("localhost", "root", "pass1234", "todo");
			//echo $db;
			//echo "made here";
			$statement = "DELETE FROM task WHERE id = '".$this->id."';";
			echo $statement;
			if($this->mySQL->execute_query($statement)){
				return 0;
			}
			echo "made here also";
			return 1;
		}
		public function update_task(){
			$statement = "UPDATE task SET name='".$this->name."', descr='".$this->descr."', priority='".$this->priority->get_pri()."', status='".$this->status->get_stat()."', due_date='".$this->due_date."' WHERE id=".$this->id.";";
			echo $statement;
			if (!$this->mySQL->execute_query($statement)){
				return 0;
			}
			return 1;
		}
		public function mark_late(){
			$statement = "UPDATE task SET status = 'late' WHERE id = ".$this->id.";";
			echo $statement;
			if (!$this->mySQL->execute_query($statement)){
				return 0;
			}
			return 1;
		}
	}
?>