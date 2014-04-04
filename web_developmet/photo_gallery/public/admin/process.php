<?php
   require_once('../includes/initialize.php');
	
	if($session->is_logged_in()) {
	  redirect_to("index.php");
	}
    
    if ( empty($username) || empty($password) ){
        echo "Username and Password are mandatory"
            exit();
    }
	
    $username = mysql_real_escape_string($_POST["username"]);
    $password = mysql_real_escape_string($_POST["password"]);
    $first_name = mysql_real_escape_string($_POST["first_name"]);
	$last_name = mysql_real_escape_string($_POST["last_name"]);

   
	
	$user = new User();
	$user ->username = $username;
	$user->password = $password;
	$user->first_name = $first_name;
	$user->last_name - $last_name;
	$user->create();
	
?>