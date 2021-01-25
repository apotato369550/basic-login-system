<?php
	if(isset($_POST["login-submit"])){
		require "dbh.inc.php";
		
		$user = $_POST["user"];
		$password = $_POST["password"];
		
		if(empty($user) or empty($password)){
			header("Location: ../index.php?error=emptyfields");
			exit();
		}
		
		$sql = "SELECT * FROM users WHERE username=? OR userEmail=?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../index.php?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "ss", $user, $user);
			mysqli_stmt_execute($stmt);
		}
		
		$result = mysqli_stmt_get_result($stmt);
		
		if(!$row = mysqli_fetch_assoc($result)){
			header("Location: ../index.php?error=assocerror");
			exit();
		}
		
		$passwordCheck = password_verify($password, $row["userPassword"]);
		
		if(!$passwordCheck){
			header("Location: ../index.php?error=wrongpassword");
			exit();
		}
		
		session_start();
		$_SESSION["userId"] = $row["userId"];
		$_SESSION["username"] = $row["username"];
		
		header("Location: ../index.php?login=success&userid=".$_SESSION["userId"]);
		exit();
	}
	