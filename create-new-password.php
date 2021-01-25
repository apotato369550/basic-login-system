<?php
	require "header.php"
?>
	<main>
		<div class="main-wrapper">
			<section class="default-section">
				<h1 id="main-title">Reset Password</h1>
				<?php
				if(isset($_GET["selector"]) and isset($_GET["validator"])){
					$selector = $_GET["selector"];
					$validator = $_GET["validator"];
					
					if(empty($selector) || empty($validator)){
						echo "Could not validate request";
					} else {
						if(ctype_xdigit($selector) != False and ctype_xdigit($validator) != False){
							?>
							
							<form action="includes/reset-password.inc.php" method="post">
								<input type="hidden" name="selector" value="<?php echo $selector ?>">
								<input type="hidden" name="validator" value="<?php echo $validator ?>">
								<input type="password" name="password" placeholder="Enter New Password..." class="form-input">
								<input type="password" name="repeat-password" placeholder="Repeat Password..." class="form-input">
								<button type="submit" name="password-reset-request" class="submit-button">Reset Password!</button>
							</form>
							
							<?php
						} else {
							echo "Could not validate request!";
						}
					}
				} else if(isset($_GET["reset"])){
					if($_GET["reset"] == "success"){
						?> <p class='success-message'>Password successfully changed</p> <?php
					} else if($_GET["reset"] == "failure"){
						?> <p>Something went wrong when trying to change your password</p> <?php
					} else {
						?> <p>Something went wrong</p> <?php
					}
				} else {
					?> <p>Something went wrong</p> <?php
				}
				?>
			</section>
		</div>
	</main>
<?php
	require "footer.php"
?>