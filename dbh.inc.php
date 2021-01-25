<?php
	$serverName = "localhost";
	$databaseUsername = "root";
	$databasePassword = "";
	$databaseName = "login system sample";
	
	$connection = mysqli_connect($serverName, $databaseUsername, $databasePassword, $databaseName);
	
	if (!$connection){
		die("Connection failed: ".mysqli_connect_error());
	} 
	