<?php
	require "header.php"
?>
	<main>
		<div class="main-wrapper">
			<section class="default-section">
				<?php
					if(isset($_SESSION["userId"])){
						?>
						<p>You are Logged in!</p>
						<a href='delete.php' class='page-link'>Delete Your Account</a>		
						<form action="includes/logout.inc.php" method="post" class="log-form" style="display:block;">
							<button type="submit" name="logout-submit" class="login-logout-button">Logout</button>
						</form>
						<?php
					} else {
						?> <p>You are Logged out</p> <?php
					}
					
					if(isset($_GET["error"])){
						$error = $_GET["error"];
						$errors = [
							"emptyfields" => "Please enter your username and password.",
							"sqlerror" => "Something went wrong when trying to log in.",
							"wrongpassword" => "Your password is invalid",
							"assocerror" => "That account does not exist.",
						];
						
						?> <p class="error-message">Error: </p> <?php
						
						if(array_key_exists($error, $errors)){
							?> <p class="error-message"><?php echo $errors[$error] ?></p> <?php
						} else {
							?> <p class="error-message">An Unexpected Error Ocurred While Handling Your Request</p> <?php
						}
					}
					
					if(isset($_GET["deletion"])){
						if($_GET["deletion"] == "success"){
							?> <p class="success-message">Account Deletion Success!</p> <?php
						}
					}
				?>
			</section>
		</div>
	</main>
<?php
	require "footer.php"
?>