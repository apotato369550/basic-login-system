<?php
	if(isset($_POST["delete-request"])){
		$selector = $_POST["selector"];
		$validator = $_POST["validator"];
		$password = $_POST["password"];
		$repeatPassword = $_POST["repeat-password"];
		
		if(empty($password) or empty($repeatPassword)){
			header("Location: ../delete-account.php?deletion=failure&error=emptyfields");
			exit();
		} 
		
		if($password != $repeatPassword){
			header("Location: ../delete-account.php?deletion=failure&error=passwordsdonotmatch");
			exit();
		}
		
		
		$currentDate = date("U");
		
		require "dbh.inc.php";
		
		$sql = "SELECT * FROM accountdelete WHERE selector=? AND expiry <= ?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete-account.php?deletion=failure&error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "si", $selector, $currentDate);
			mysqli_stmt_execute($stmt);
		}
		
		$result = mysqli_stmt_get_result($stmt);
		
		if(!$row = mysqli_fetch_assoc($result)){
			header("Location: ../delete-account.php?deletion=failure&error=requestnotfound");
			exit();
		}
		
		$email = $row["email"];

		$sql = "SELECT * FROM users WHERE userEmail=?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete-account.php?deletion=failure&error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
		}
		
		$result = mysqli_stmt_get_result($stmt);
		
		if(!$row = mysqli_fetch_assoc($result)){
			header("Location: ../delete-account.php?deletion=failure&error=accountnotfound");
			exit();
		}
		
		$passwordCheck = password_verify($password, $row["userPassword"]);
		
		if(!$passwordCheck){
			header("Location: ../delete-account.php?deletion=failure&error=incorrectpassword");
			exit();
		}
		
		
		$username = $row["username"];
		
		$sql = "DELETE FROM users WHERE userEmail=? AND username=?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete-account.php?deletion=failure&error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "ss", $email, $username);
			mysqli_stmt_execute($stmt);
		}
		
		$sql = "DELETE FROM accountdelete WHERE email=?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete-account.php?deletion=failure&error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
		}
		
		require "logout.inc.php";
		
		header("Location: ../index.php?deletion=success");
		exit();
	}
