<?php
require_once("../../includes/initialize.php");

if($session->is_logged_in()) {
  redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  
  // Check database to see if username/password exist.
	$found_user = User::authenticate($username, $password);
	
  if ($found_user) {
    $session->login($found_user);
		log_action('Login', "{$found_user->username} logged in.");
    redirect_to("index.php");
  } else {
    // username/password combo was not found in the database
    $message = "Username/password combination incorrect.";
  }
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
}

?>
<?php include_layout_template('admin_header.php'); ?>

		<h2>Login</h2>
		<?php echo output_message($message); ?>

		<form class="form-signin" action="login.php" method="post">
			<h2 class="form-signin-heading"> Signin </h2>
		        <input type="text" class="form-control" placeholder="Username" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" required autofocus/>
		        <input type="password" class="form-control" placeholder="Password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" required/>
		        <input type="submit" name="submit" value="Login" />
		</form>

<?php include_layout_template('admin_footer.php'); ?>
