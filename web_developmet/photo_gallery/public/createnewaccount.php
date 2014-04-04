<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

    <title>Create Account</title>

    <!-- Bootstrap core CSS -->
    <link href="stylesheets/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="stylesheets/signin.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
	    <script src="http://malsup.github.com/jquery.form.js"></script> 
 

  </head>

  <body>

    <div class="container">

      <form class="form-signin" id="newuser" action="process.php" method="POST">
        <h2 class="form-signin-heading">Create Account</h2>
        <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" required autofocus/>
        <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" />
        <input type="text" class="form-control" placeholder="UserName" name="username"  id="username" required />
        <input type="password" class="form-control" placeholder="Password" id="password" required />
    
      
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit">Create Account</button>
      </form>
      
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script> 
	        // wait for the DOM to be loaded 
	        $(document).ready(function() { 
	            // bind 'myForm' and provide a simple callback function 
	            $('#newuser').ajaxForm(function() { 
					var name = $("#username").val();
					if (name.length < 3) {
					             alert("username must be more than 3 characters"); 
					     
					        }
	            }); 
	        }); 
	    </script> 
      <script type="text/javascript" src="uservalidation.js"></script>
  </body>
</html>
