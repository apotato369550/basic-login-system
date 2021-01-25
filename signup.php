<?php
	require "header.php"
?>
	<main>
		<div class="main-wrapper">
			<section class="default-section">
				<h1 id="main-title">Sign Up</h1>
					<?php
						if(isset($_GET["error"])){
							$error = $_GET["error"];
							$errors = array(
								"emptyfields" => "Error: Empty Fields",
								"invalidusernameandemail" => "Error: Invalid username and Email",
								"invalidemail" => "Error: Invalid Email",
								"invalidusername" => "Error: Invalid Username",
								"passwordcheck" => "Error: Passwords Do Not Match",
								"sqlerror" => "Error: SQL Error. Please try again later or contact the server admin for help.",
								"usernameinuse" => "Error: Username Already In Use"
							);
							
							if(array_key_exists($error, $errors)){
								?> <p class="error-message"><?php echo $errors[$error] ?></p> <?php
							} else {
								?> <p class="error-message">An Unexpected Error Ocurred While Handling Your Request</p> <?php
							}
						} else if(isset($_GET["signup"]) and $_GET["signup"] == "success"){
								?> <p class='success-message'>Account Successfully Created!</p> <?php
						} else if(isset($_GET["passwordchange"]) and $_GET["passwordchange"] == "success"){
								?> <p class='success-message'>Password Successfully Changed!</p> <?php
						}
					?>
				<form action="includes/signup.inc.php" method="post" class="log-form">
					<?php
						if(isset($_GET["username"])){
							$username = $_GET["username"];
							?> <input type="text" name="username" placeholder="Username" class="form-input" value="<?php echo $username ?>"> <?php
						} else {
							?> <input type="text" name="username" placeholder="Username" class="form-input"> <?php
						}
						
						if(isset($_GET["email"])){
							$email = $_GET["email"]
							?> <input type="email" name="email" placeholder="Email" class="form-input" value="<?php echo $email ?>"> <?php
						} else {
							?> <input type="email" name="email" placeholder="Email" class="form-input"> <?php
						}
					?>
					<input type="password" name="password" placeholder="Password" class="form-input">
					<input type="password" name="password-repeat" placeholder="Repeat Password" class="form-input">
					<button type="submit" name="signup-submit" class="submit-button">Sign Up</button>
				</form>
				
				<a href="reset-password.php" id="forgot-password">Forgot your password?</a>
			</section>
		</div>
	</main>
<?php
	require "footer.php"
?>