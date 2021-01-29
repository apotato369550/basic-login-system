<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
	
if(isset($_POST["password-reset-submit"])){
	
	$selector = bin2hex(random_bytes(8));
	$token = random_bytes(32);
	
	$url = "http://localhost/Sample%20Login%20System/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);
	
	$expiry = date("U"); + 1800;
	
	require "dbh.inc.php";
	
	$email = $_POST["email"];
	
	if(empty($email)){
		header("Location: ../reset-password.php?reset=failure&error=emptyfields");
		exit();
	}
	
	$sql = "DELETE FROM resetpassword WHERE email=?";
	$stmt = mysqli_stmt_init($connection);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../reset-password.php?reset=failure&error=sqlerror");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
	}
	
	$sql = "INSERT INTO resetpassword (email, selector, token, expiry) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_stmt_init($connection);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../reset-password.php?reset=failure&error=sqlerror");
		exit();
	} else {
		$hashedToken = password_hash($token, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expiry);
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($connection);
	
	
	require "../vendor/autoload.php";
	
	try{
		
		$mail = new PHPMailer(true);
		
		$mail->SMTPDebug = 2;                    
		$mail->isSMTP();                                          
		$mail->Host = 'smtp.gmail.com';                  
		$mail->SMTPAuth = true;                                
		$mail->Username = 'insertemailhere@gmail.com';               
		$mail->Password = 'password123';                              
		$mail->SMTPSecure = "tls";       
		$mail->Port = 587;      
		
		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
		);
               
		$mail->setFrom('insertemailhere@gmail.com', 'no-reply');
		$mail->addAddress($email);
		
		$mail->isHTML(True);
		$mail->Subject = 'Password Reset Request from localhost';
		$mail->Body = '<p>We received a request to reset your password. The link to do so is down below. If  you did not make this request, feel free to ignore this email.</p>';
		$mail->Body .= '<p>Here is your link. It expires in 30 minutes:</p>';
		$mail->Body .= '<a href="'.$url.'">'.$url.'</a>';
		
		$mail->send();
		
		header("Location: ../reset-password.php?reset=success");
		exit();
	} catch (Exception $e) {
		header("Location: ../reset-password.php?reset=failure&error=mailererror");
		exit();
	}
}
