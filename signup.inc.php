<?php
	if(isset($_POST["signup-submit"])){
		require "dbh.inc.php";
		
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$repeatedPassword = $_POST["password-repeat"];
		
		if(empty($username) or empty($email) or empty($password) or empty($repeatedPassword)){
			header("Location: ../signup.php?error=emptyfields");
			exit();
		} 
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) and !preg_match("/^[a-zA-Z0-9]*$/", $username)){
			header("Location: ../signup.php?error=invalidusernameandemail");
			exit();
		} 
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) ){
			header("Location: ../signup.php?error=invalidemail&username=".$username);
			exit();
		} 
		
		if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
			header("Location: ../signup.php?error=invalidusername&email=".$email);
			exit();
		} 
		
		if($password != $repeatedPassword){
			header("Location: ../signup.php?error=passwordcheck&username=".$username."&email=".$email);
			exit();
		}
		
		$sql = "SELECT userId FROM users WHERE userId=?";
		$stmt = mysqli_stmt_init($connection);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signup.php?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
		}
			
		$resultCheck = mysqli_stmt_num_rows($stmt);
		
		if ($resultCheck > 0) {
			header("Location: ../signup.php?error=usernameinuse&email=".$email);
			exit();	
		}
		
		$sql = "INSERT INTO users (username, userEmail, userPassword) VALUES (?, ?, ?)";
		$stmt = mysqli_stmt_init($connection);
		
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signup.php?error=sqlerror");
			exit();
		} else {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			
			mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
			mysqli_stmt_execute($stmt);
		}
		
		header("Location: ../signup.php?signup=success");
		exit();
		
		
		mysqli_stmt_close($stmt);
		mysqli_close($connection);
		
	}
