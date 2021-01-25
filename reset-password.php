<?php
	require "header.php"
?>
	<main>
		<div class="main-wrapper">
			<section class="default-section">
				<h1 id="main-title">Reset Password</h1>
				<p>An email will be sent containing instructions on how to reset your password.</p>
				
				<form action="includes/reset-request.inc.php" method="post" class="log-form">
					<input type="text" class="form-input" name="email" placeholder="Enter your Email Address...">
					<button type="submit" class="submit-button" name="password-reset-submit">Reset Password</button>
				</form>
				<?php
					if(isset($_GET["reset"])){
						if($_GET["reset"] == "success"){
							?> <p class='success-message'>Check your email!</p> <?php
						} else if ($_GET["reset"] == "failure"){
							$error = $_GET["error"];
							$errors = [
								"emptyfields" => "Please enter your email.",
								"sqlerror" => "A SQL error has ocurred.",
								"mailererror" => "A mailer error has ocurred"
							];
							
							?> <p class="error-message">Error: </p> <?php
							
							if(array_key_exists($error, $errors)){
								?> <p class="error-message"><?php echo $errors[$error] ?></p> <?php
							} else {
								?> <p class="error-message">An Unexpected Error Ocurred While Handling Your Request</p> <?php
							}
						}
					}
				?>
			</section>
		</div>
	</main>
<?php
	require "footer.php"
?>