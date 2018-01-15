<?php
	require_once('class.mySQLDAO.php');
	if(!$mySQL = new mySQLDAO()){
		print "unable to connect to mySQL.\n";
	}
	else{
		print "successfully connected to mySQL.\n";
	}
	if(!$mySQL->create_DB()){
		print "unable to establish connection to DB.\n";
	}
	else{
		print "successfully connected to DB.\n";
	}
	if(!$mySQL->create_tables()){
		print "unable to create one or more tables.\n";
	} 
	else{
	print "successfully created the tables.\n";
	}
	if(!$mySQL->populate_task()){
		print "unable to populate task table.\n";
	}
	else{
		print "successfully populated the task table.\n";
	}
	/*if(!$mySQL->close_conn()){
		print "unable to close connection.\n";
	}
	else{
		print "successfully closed connection.\n";
	}*/
?>