<?php 
	class mySQLDAO{
		private $conn;
		
		public function __construct($_host, $_username, $_pass){
			$this->conn = new mysqli("localhost", "root", "pass1234");
		}
		public function connect_db($_db){
			$this->conn = new mysqli("localhost", "root", "pass1234", "todo");
		}
		public function create_DB(){
			$r1 = $this->conn->query("CREATE DATABASE IF NOT EXISTS todo;");
	
			$this->conn = new mysqli("localhost", "root", "pass1234", "todo");
		}
		public function create_tables(){
			$r3 = $this->conn->query("CREATE TABLE task(id INTEGER AUTO_INCREMENT, name VARCHAR(15), descr VARCHAR(255), priority ENUM('high', 'medium', 'low'), status ENUM('pending', 'started', 'completed', 'late'), due_date DATE, PRIMARY KEY(id), FOREIGN KEY(priority) REFERENCES priority (priority), FOREIGN KEY(status) REFERENCES status(status));");
			
			$r4 = $this->conn->query("CREATE TABLE priority(priority ENUM('high', 'medium', 'low'), PRIMARY KEY(priority));");
			
			$r5 = $this->conn->query("CREATE TABLE status(status ENUM('pending', 'started', 'completed', 'late'), PRIMARY KEY(status));");
			
			$this->populate_priority();
			$this->populate_status();
			
		}
		private function populate_priority(){
			$options = ['high', 'medium', 'low'];
			
			for ($i=0; $i<3; $i++){
				$statement = "INSERT INTO priority VALUES('".$options[$i]."');";
				$r6 = $this->conn->query($statement);
			}
			
		}
		private function populate_status(){
			$options = ['pending', 'started', 'completed', 'late'];
			
			for ($i=0; $i<3; $i++){
				$statement = "INSERT INTO status VALUES('".$options[$i]."');";
				$r7 = $this->conn->query($statement);
			}
		}
		public function execute_query($statement){
			$r7 = $this->conn->query($statement);
			return $r7;
		}
	}
?>