<?php
	require "header.php"
?>
	<main>
		<div class="main-wrapper">
			<section class="default-section">
				<h1 id="main-title"> Delete Your Account</h1>
				<form action="includes/delete-request.inc.php" method="POST" class="log-form">
					<input value="<?php echo $_SESSION["username"]?>" name="username" type="hidden"> 
					<button type="submit" name="confirm-request" class="submit-button">Delete Account</button>
				</form>
				<p>After clicking the button, an account deletion request will be sent to your email. </p>
				
				<?php
					if(isset($_GET["deletion"])){
						if($_GET["deletion"] == "success"){
							?> <p class="success-message">Check your email!</p><?php
						} else if($_GET["deletion"] == "failure"){
							if(isset($_GET["error"])){
								$error = $_GET["error"];
								$errors = [
									"sqlerror" => "A SQL error has occured",
									"accountnotfound" => "Could not find your account. How tf are you here?",
									"mailererror" => "A mailer error has ocurred"
								];
								
								if(array_key_exists($error, $errors)){
									?> <p class="error-message"><?php echo $errors[$error] ?></p> <?php
									if($error = "mailererror" and isset($_GET["errordetails"])){
										?> <p class="error-message"><?php echo $_GET["errordetails"] ?></p> <?php
									}
								} else {
									?> <p class="error-message">An unexpected error ocurred while processing your request.</p><?php
								}
							} else {
								?> <p class="error-message">An unexpected error ocurred while processing your request.</p><?php
							}
						}
					}
				?>
				
				<a class="page-link" href="index.php">Go Back</a>
			</section>
		</div>
	</main>
<?php
	require "footer.php"
?>