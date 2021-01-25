<?php
	session_start();
?>

<DOCTYPE! html>
<html>
	<head>
		<title> Sample Login System </title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<header>
			<nav id="navbar">
			
				<a href="index.php"><img src="logo.png" alt="logo" class="logo"></a>
				<ul class="nav-links">
					<li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
					<li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
					<li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
					<li class="nav-item"><a href="#" class="nav-link">Support</a></li>
				</ul>
				<?php 
					if(!isset($_SESSION["userId"])){
				?>
				
				<form action="includes/login.inc.php" method="post" class="log-form">
					<input type="text" name="user" placeholder="Enter Username/Email" class="form-input">
					<input type="password" name="password" placeholder="Enter Password" class="form-input">
					<button type="submit" name="login-submit" class="login-logout-button">Login</button>
				</form>
				<a href="signup.php" class="page-link">Signup</a>
				<?php
					}
				?>
				
				
			</nav>
		</header>