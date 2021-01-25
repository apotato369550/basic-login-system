<?php
	if(isset($_POST["password-reset-request"])){
		$selector = $_POST["selector"];
		$validator = $_POST["validator"];
		$password = $_POST["password"];
		$repeatPassword = $_POST["repeat-password"];
		
		if(empty($password) or empty($repeatPassword)){
			header("Location: ../create-new-password.php?password=empty");
			exit();
		} 
		
		if($password !== $repeatPassword){
			header("Location: ../create-new-password.php?password=notsame");
			exit();
		}
		
		$currentDate = date("U");
		
		require "dbh.inc.php";
		
		$sql = "SELECT * FROM resetpassword WHERE selector=? AND expiry <= ?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../create-new-password.php?error=selectorerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "si", $selector, $currentDate);
			mysqli_stmt_execute($stmt);
		}
			
		$result = mysqli_stmt_get_result($stmt);
		
		if(!$row = mysqli_fetch_assoc($result)){
			header("Location: ../create-new-password.php?passwordchange=failure&error=requestnotfound");
			exit();
		}
		
		$tokenBin = hex2bin($validator);
		$tokenCheck = password_verify($tokenBin, $row["token"]);
		
		if(!$tokenCheck){
			header("Location: ../create-new-password.php?passwordchange=failure&error=falsetoken");
			exit();
		}
		
		$tokenEmail = $row["email"];
		
		$sql = "SELECT * FROM users WHERE userEmail=?";
		$stmt = mysqli_stmt_init($connection);

		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../create-new-password.php?error=useremailerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
			mysqli_stmt_execute($stmt);
		}
			
		$result = mysqli_stmt_get_result($stmt);
		
		if(!$row = mysqli_fetch_assoc($result)){
			header("Location: ../create-new-password.php?passwordchange=failure&error=emailnotfound");
			exit();
		} 
		
		$sql = "UPDATE users SET userPassword=? WHERE userEmail=?";
		$stmt = mysqli_stmt_init($connection);

		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../create-new-password.php?error=updateerror");
			exit();
		} else {
			$newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
			mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash, $tokenEmail);
			mysqli_stmt_execute($stmt);
		}
			
		$sql = "DELETE FROM resetpassword WHERE email=?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../create-new-password.php?error=deletionerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
			mysqli_stmt_execute($stmt);
			header("Location: ../signup.php?passwordchange=success");
		}
	} 
	