<?php 
	class mySQLDAO{
		private $conn = null;
		private $mySQL_details;
		private $host;
		private $username;
		private $password;
		private $db;
		
		public function __construct(){
			$this->mySQL_details = require_once('config/config.php');
			$this->host = $this ->mySQL_details['host'];
			$this->username = $this->mySQL_details['username'];
			$this->password = $this->mySQL_details['pass'];
			$this->db = $this->mySQL_details['db'];
			try{
				$this->conn = new mysqli($this->host, $this->username, $this->password);
			} catch (Exception $e){
				print "Error encountered, unable to establish connection to mySQL: ".$e;
				return 0;
			}
			
			return 1;
		}
		public function connect_db(){
			try{
				$this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
			} catch (Exception $e){
				print "Error encountered, unable to establish connection to mySQL todo database: ".$e;
				return 0;
			}
			return 1;
		}
		public function create_DB(){
			try{
				$r1 = $this->conn->query("CREATE DATABASE IF NOT EXISTS todo;");
			} catch (Exception $e){
				print "Error encountered, unable to create todo database: ".$e;
				return 0;
			}
			try{
				$this->conn = new mysqli("localhost", "root", "pass1234", "todo");
			} catch (Exception $e){
				print "Error encountered, unable to establish connection to mySQL todo database: ".$e;
				return 0;
			}
			return 1;
		}
		public function create_tables(){
			try{
				$r3 = $this->conn->query("CREATE TABLE task(id INTEGER AUTO_INCREMENT, name VARCHAR(15), descr VARCHAR(255), priority ENUM('high', 'medium', 'low'), status ENUM('pending', 'started', 'completed', 'late'), due_date DATE, PRIMARY KEY(id), FOREIGN KEY(priority) REFERENCES priority (priority), FOREIGN KEY(status) REFERENCES status(status));");
			} catch (Exception $e){
				print "Error encountered, unable to create table 'task': ".$e;
				return 0;
			}
			
			try{
				$r4 = $this->conn->query("CREATE TABLE priority(priority ENUM('high', 'medium', 'low'), PRIMARY KEY(priority));");
			} catch (Exception $e){
				print "Error encountered, unable to create table 'priority': ".$e;
				return 0;
			}
			
			try{
				$r5 = $this->conn->query("CREATE TABLE status(status ENUM('pending', 'started', 'completed', 'late'), PRIMARY KEY(status));");
			} catch (Exception $e){
				print "Error encountered, unable to create table 'status': ".$e;
				return 0;
			}
			
			if(!$this->populate_priority()){
				return 0;
			}
			if(!$this->populate_status()){
				return 0;
			}
			return 1;
		}
		private function populate_priority(){
			$options = ['high', 'medium', 'low'];
			
			for ($i=0; $i<3; $i++){
				try{
					$statement = "INSERT INTO priority VALUES('".$options[$i]."');";
					$r6 = $this->conn->query($statement);
				} catch (Exception $e){
					print "Error encountered, unable to populate table 'priority': ".$e;
					return 0;
				}
			}
			return 1;
			
		}
		private function populate_status(){
			$options = ['pending', 'started', 'completed', 'late'];
			
			for ($i=0; $i<4; $i++){
				try{
					$statement = "INSERT INTO status VALUES('".$options[$i]."');";
					$r7 = $this->conn->query($statement);
				} catch (Exception $e){
					print "Error encountered, unable to populate table 'status': ".$e;
					return 0;
				}
			}
			return 1;
		}
		public function populate_task(){
			$dummy_data = [['buy groceries', '...', 'high', 'started', '01-13-2018'],
							['dishes', '...', 'medium', 'pending', '02-21-2018'],
							['homework', '...', 'high', 'completed', '03-05-2018'],
							['laundry', '...', 'low', 'pending', '01-12-2018'],
							['pay bills', '...', 'medium', 'late', '12-12-2017']];
			
			for ($i = 0; $i<sizeof($dummy_data); $i++){
				$statement = "INSERT INTO task VALUES(".$dummy_data[$i][0].",".$dummy_data[$i][1].",".$dummy_data[$i][2].",".$dummy_data[$i][3].",".$dummy_data[$i][4].");";
				try{
					$this->execute_query($statement);
				} catch (Exception $e){
					print "Error encountered, unable to add row to task table: ".$e;
					return 0;
				}
			}
			return 1;
		}
		public function execute_query($statement){
			try{
				$r7 = $this->conn->query($statement);
				return $r7;
			} catch (Exception $e){
				print "Error encountered, unable to execute SQL statement ".$statement.": ".$e;
				return 0;
			}
		}
	}
?>