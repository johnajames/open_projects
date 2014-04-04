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
	<title>LoL-DB : View Player</title>
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
<div class='container' style='text-align:center'>
	<h2>Matches</h2>
	<table class='table table-striped'>
		<tr>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Summoner Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>First Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Last Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Role</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>GPM</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>KDA</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Average CS</strong></td>

		</tr>
<!-- View player info -->
<?php
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
	$sth = $sql->query("SELECT summoner_name AS Summoner, 
		first_name AS First_Name, last_name AS Last_Name,
		role AS Role, gpm AS GPM, cs AS Average_CS,
		kda as KDA FROM people");
	$sth->setFetchMode(PDO::FETCH_OBJ);
	
	/* display team info */
	while ($obj = $sth->fetch())
	{
		echo "<tr>";
			echo "<td class='col-lg-2 col-md-2 col-sm-2'>".$obj->Summoner."</td>";
			echo "<td class='col-lg-2 col-md-2 col-sm-2'>".$obj->First_Name."</td>";
			echo "<td class='col-lg-2 col-md-2 col-sm-2'>".$obj->Last_Name."</td>";
			echo "<td class='col-lg-2 col-md-2 col-sm-2'>".$obj->Role."</td>";
			echo "<td class='col-lg-2 col-md-2 col-sm-2'>".$obj->GPM."</td>";
			echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->KDA."</td>";
			echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->Average_CS."</td>";
			if ($obj->lcs == 1)
				$lcs = "Yes";
			else
				$lcs = "No";
		echo "</tr>";
	}
} catch(PDOException $e) {
	echo $e->getMessage();
}

/* close db connected */
$sql = NULL;
?>


	</table>
</div>
</body>
</html>