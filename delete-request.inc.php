<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	if(isset($_POST["confirm-request"])){
		$username = $_POST["username"];
		
		require "dbh.inc.php";
		
		$sql = "SELECT * FROM users WHERE username=?";
		$stmt = mysqli_stmt_init($connection); 
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete.php?deletion=failure&error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
		}
		
		$result = mysqli_stmt_get_result($stmt);
		
		if(!$row = mysqli_fetch_assoc($result)){
			header("Location: ../delete.php?deletion=failure&error=accountnotfound");
			exit();
		}
			
		$selector = bin2hex(random_bytes(8));
		$token = random_bytes(32);
		$expiry = date("U"); + 1800;
		
		$url = "http://localhost/Sample%20Login%20System/delete-account.php?selector=".$selector."&validator=".bin2hex($token);
		
		$email = $row["userEmail"];
		
		$sql = "DELETE FROM accountdelete WHERE email=?";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete.php?deletion=failure&error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
		}
		
		$sql = "INSERT INTO accountdelete (email, selector, token, expiry) VALUES (?, ?, ?, ?)";
		$stmt = mysqli_stmt_init($connection);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../delete.php?deletion=failure&error=sqlerror");
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
			$mail->Subject = 'Account Deletion Request from localhost';
			$mail->Body = '<p>We received a request to delete your account. The link below will lead you to a page where you can delete your account. If  you did not make this request, feel free to ignore this email.</p>';
			$mail->Body .= '<p>Here is your link. It expires in 30 minutes:</p>';
			$mail->Body .= '<a href="'.$url.'">'.$url.'</a>';
			
			$mail->send();
			
			header("Location: ../delete.php?deletion=success");
			exit();
		} catch (Exception $e) {
			header("Location: ../delete.php?deletion=failure&error=mailererror&errordetails".$mail->ErrorInfo);
			exit();
		}
	}
		