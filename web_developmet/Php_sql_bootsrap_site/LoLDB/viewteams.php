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
	<title>LoL-DB : Landing</title>
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
	<h2>Teams</h2>
	<table class='table table-striped'>
		<tr>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Team Name</strong></td>
			<td class='col-lg-3 col-md-3 col-sm-3'><strong>Wins</strong></td>
			<td class='col-lg-3 col-md-3 col-sm-3'><strong>Losses</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>LCS</strong></td>
		</tr>
<!-- View a list of teams -->
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
	$sth = $sql->query("SELECT team_id, team_name, wins, losses, lcs, region FROM teams");
	$sth->setFetchMode(PDO::FETCH_OBJ);
	
	/* display team info */
	while ($obj = $sth->fetch())
	{
		echo "<tr>";
			echo "<td class='col-lg-4 col-md-4 col-sm-4'><a href='viewteam.php?team=".$obj->team_id."'>".$obj->team_name."</a></td>";
			echo "<td class='col-lg-3 col-md-3 col-sm-3'>".$obj->wins."</td>";
			echo "<td class='col-lg-3 col-md-3 col-sm-3'>".$obj->losses."</td>";
			if ($obj->lcs == 1)
				$lcs = "Yes";
			else
				$lcs = "No";
			echo "<td class='col-lg-2 col-md-2 col-sm-2'>".$lcs."</td>";
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