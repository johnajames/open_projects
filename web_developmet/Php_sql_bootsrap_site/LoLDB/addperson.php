<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="loginstyle.css">
	<script src="jquery.validate.js"></script>-->
	<script src="jquery.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/starter-template.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
	<meta charset="UTF-8">
	<title>LoL-DB : Add Person</title>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">League of Legends Match Tracker</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
           <li><a href="#">Home</a></li>
            <li><a href="#">LoL Blog</a></li>
            <li class="active"><a href="landing.php">Stat Tracker</a></li>
            <li><a href="#t">Sign In</a></li>
            <li><a href="#">Create Account</a></li>
            <li><a href="#">About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <!-- end of navigation bar -->    
    <br>
    <br>
    
    <!-- large page image
    <div class="container">
        <img src="http://www.bubblews.com/assets/images/news/1971937940_1369406888.jpg">
    </div>-->    
    
<?php
/* Database information */
$host = "oniddb.cws.oregonstate.edu";
$dbname = "burrowsd-db";
$dbuser = "burrowsd-db";
$dbpass = "Pvlh12MLwduJsopk";
?>

    <!-- enclosing form portion in container for proper margins and padding -->
<div class="container" style="text-align:center">    

<!--
	To dos:
	-Make it pretty
--> 
    <!-- Using Bootstrap Cols and rows to separate content -->
	<h2>Match Entry Form</h2>
	<form method="post" id="teams">
	<table class="table table-striped">
		<tr>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Summoner Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>First Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Last Name</strong></td>
		</tr>
		<tr>
			<td class="col-lg-2 col-md-2 col-sm-2"><input type="text" name="name" id="name" maxlength="45"></td>
			<td class="col-lg-2 col-md-2 col-sm-2"><input type="text" name="fname" id="fname" maxlength="45"></td>
			<td class="col-lg-2 col-md-2 col-sm-2"><input type="text" name="lname" id="lname" maxlength="45"></td>
		</tr>
	</table>
	<br>
	<br>
	<table class="table table-striped">
		<tr>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Role</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>GPM</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Average CS</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>KDA</strong></td>
		</tr>
		<tr>
			<td class='col-lg-2 col-md-2 col-sm-2'>
				<?php
				/* insert roles */
				$host = "oniddb.cws.oregonstate.edu";
				$dbname = "burrowsd-db";
				$dbuser = "burrowsd-db";
				$dbpass = "Pvlh12MLwduJsopk";

				/* create PDO for MySQL access */
				try {
					$sql = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				try {
					/* display team information */
					$sth = $sql->query("SELECT role_id, role_name FROM roles");
					$sth->setFetchMode(PDO::FETCH_OBJ);
					
					/* display team info */
					echo "<select class='role' name='role' id='role'>";
					while ($obj = $sth->fetch())
					{
						echo "<option value='".$obj->role_id."'>".$obj->role_name."</option>";
					}
					echo "</select>";
				} catch(PDOException $e) {
					echo $e->getMessage();
				}

				/* close db connected */
				$sql = NULL;
				?>		
			</td>			
			<td class="col-lg-2 col-md-3 col-sm-1"><input type="text" name="gpm" id="gpm" maxlength="10"></td>
			<td class="col-lg-2 col-md-3 col-sm-1"><input type="text" name="cs" id="cs" maxlength="10"></td>
			<td class="col-lg-2 col-md-3 col-sm-1"><input type="text" name="kda" id="kda" maxlength="10"></td>
		</tr>
	</table>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default" onclick="postAJAX()">Add Person</button>
	</span>
		<!--<input type='submit' value='Submit'>-->
	</form>
<!-- ends data submission table -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
</div>
<script src="bootstrap.min.js"></script>
</body>
<script>

function postAJAX()
{
	/* for ajax error, success, complete */
	$(function(){
	$("#teams").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var post_url = "postperson.php";
		var post_data = form.serialize();
		$.ajax({
			type: "POST",
			url: post_url,
			data: post_data,
			success: function(){
				/* Do something on success */
				alert("Data uploaded");
				//location.reload();
			},
			error: function() {
				/* send to an error log */
				alert("An error has occurred");
			},
			complete: function(){
				/* do something on complete, runs after error and success */
				location.reload();
			}
		})
	});
	})
}
</script>
</html>