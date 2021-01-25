<?php
	require "header.php"
?>
	<main>
		<div class="main-wrapper">
			<section class="default-section">
				<?php
					// Restructured:
					
					if(isset($_GET["deletion"])){
						$result = $_GET["deletion"];
						
						if($result == "success"){
							?> <p class="success-message">Account Successfully Deleted! </p> <?php
						} else if($result == "failure"){
							$error = $_GET["error"];
							$errors = [
								"emptyfields" => "Error: Please enter your password.",
								"passwordsdonotmatch" => "Error: Passwords do not match.",
								"sqlerror" => "Error: An SQL error has ocurred.",
								"accountnotfound" => "Error: Could not find the account you were trying to delete.",
								"incorrectpassword" => "Error: The password you entered was incorrect.",
							];
							
							if(array_key_exists($error, $errors)){
								?> <p class="error-message"><?php echo $errors[$error] ?></p> <?php
							} else {
								?> <p class="error-message">An Unexpected Error Ocurred While Handling Your Request</p> <?php
							}
						} else {
							?> <p class="error-message">An Unexpected Error Ocurred While Handling Your Request</p> <?php
						}
					} else if(isset($_GET["selector"]) and isset($_GET["validator"])){
						$selector = $_GET["selector"];
						$validator = $_GET["validator"];
						
						if((!empty($selector) or !empty($validator)) and 
						(ctype_xdigit($selector) and ctype_xdigit($validator))){
							?>
							<h1 id="main-title"> Delete Your Account</h1>
							
							<form action="includes/delete-account.inc.php" method="post">
								<input type="hidden" name="selector" value="<?php echo $selector ?>">
								<input type="hidden" name="validator" value="<?php echo $validator ?>">
								<input type="password" name="password" placeholder="Enter Password..." class="form-input">
								<input type="password" name="repeat-password" placeholder="Repeat Password..." class="form-input">
								<button type="submit" name="delete-request" class="submit-button">Delete Your Account!</button>
							</form>
							
							<?php
						} else {
							?> <p class="error-message">Could not Validate your request.</> <?php
						}
						
					} else {
						?> <p class="error-message">Something went wrong.</> <?php
					} 
				?>
			</section>
		</div>
	</main>
<?php
	require "footer.php"
?>
