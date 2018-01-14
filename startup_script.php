<?php
	require_once('class.mySQLDAO.php');
	if(!$mySQL = new mySQLDAO()){
		print "unable to connect to mySQL.\n";
	}
	print "successfully connected to mySQL.\n";
	if(!$mySQL->create_DB()){
		print "unable to establish connection to DB.\n";
	}
	print "successfully connected to DB.\n";
	if(!$mySQL->create_tables()){
		print "unable to create one or more tables.\n";
	}
	print "successfully created the tables.\n";
	if(!$mySQL->populate_task()){
		print "unable to populate task table.\n";
	}
	print "successfully populated the task table.\n";
?>