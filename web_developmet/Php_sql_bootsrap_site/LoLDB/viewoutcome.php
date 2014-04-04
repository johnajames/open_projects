<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="loginstyle.css">
	<script src="jquery.validate.js"></script>-->
	<script src="jquery.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/starter-template.css" rel="stylesheet">
    <!--<link href="css/custom.css" rel="stylesheet">-->
	<meta charset="UTF-8">
	<title>LoL-DB : View Outcome</title>
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
<!-- pull and display game information -->
<div class='container' style='text-align:center'>
	<h2>View Outcome</h2>
	<table class='table table-striped'>
		<tr>
			<td class='col-lg-3 col-md-1 col-sm-1'><strong>Summoner</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Champion</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Kills</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Deaths</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Assists</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Total Gold</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Creep Score</strong></td>
		</tr>
	</table>
	<br>
	<table class='table table-striped'>
	<!-- begin php to add data from database -->
<?php
/* Database information */
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
/* determine which team to view */
if (isset($_GET['game']))
{
	$game = $_GET['game'];
}
//$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	/* display team information */
	$sth = $sql->query("
		SELECT p.summoner_name, o.champion, o.kills,
		o.deaths, o.assists, o.totalgold, o.cs
		FROM outcome AS o
		INNER JOIN people p ON p.ppl_id = o.player
		WHERE o.game_id=".$game."");
		$sth->setFetchMode(PDO::FETCH_OBJ);
		$count = 0;

		while($outcome = $sth->fetch())
		{
			/* pass results of query to display */
			displayOutcome($outcome);
			$count++;
			if ($count == 5)
				echo "</table><br><table class='table table-striped'>";
		}
} catch(PDOException $e) {
	echo $e->getMessage();
}
function displayOutcome($outcome)
{
	/* Display header */
	echo "<tr>";
		echo "<td class='col-lg-3 col-md-1 col-sm-1'>".$outcome->summoner_name."</td>";
		echo "<td class='col-lg-2 col-md-1 col-sm-1'>".$outcome->champion."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$outcome->kills."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$outcome->deaths."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$outcome->assists."</td>";
		echo "<td class='col-lg-2 col-md-1 col-sm-1'>".$outcome->totalgold."</td>";
		echo "<td class='col-lg-2 col-md-1 col-sm-1'>".$outcome->cs."</td>";
	echo "</tr>";
}

/* close PDO and database connection */
$sql = NULL;
?>
	</table>
	<br>
</div>
<script src="bootstrap.min.js"></script>
</body>
<script>
function loadGame(game)
{
	/* for load the edit team page */
	var gameLocation = "viewgamelog.php?game=" + game;
	window.location=gameLocation;
}
</script>
</html>
