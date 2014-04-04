<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="loginstyle.css">
	<script src="jquery.validate.js"></script>-->
	<script src="jquery.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/starter-template.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
	<meta charset="UTF-8">
	<title>LoL-DB : View Team</title>
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
<!-- pull and display team information -->
<div class='container' style='text-align:center'>
	<h2>View Team</h2>
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
if (isset($_GET['team']))
{
	$team = $_GET['team'];
}
$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	/* display team information */
	$sth = $sql->query("SELECT t.team_name, t.wins, t.losses, t.lcs, t.region,
		P1.summoner_name AS top, P2.summoner_name AS mid,
		P3.summoner_name AS jng, P4.summoner_name AS adc,
		P5.summoner_name AS sup, P6.summoner_name AS sub1,
		P7.summoner_name AS sub2 FROM teams AS t
		LEFT OUTER JOIN people AS P1 ON P1.ppl_id = t.top
		LEFT OUTER JOIN people AS P2 ON P2.ppl_id = t.mid
		LEFT OUTER JOIN people AS P3 ON P3.ppl_id = t.jungler
		LEFT OUTER JOIN people AS P4 ON P4.ppl_id = t.marksman
		LEFT OUTER JOIN people AS P5 ON P5.ppl_id = t.support
		LEFT OUTER JOIN people AS P6 ON P6.ppl_id = t.sub1
		LEFT OUTER JOIN people AS P7 ON P7.ppl_id = t.sub2
		WHERE t.team_id=".$team."");
		$sth->setFetchMode(PDO::FETCH_OBJ);
		$obj = $sth->fetch();
		/* pass results of query to display */
		displayTeam($obj);
} catch(PDOException $e) {
	echo $e->getMessage();
}

function displayTeam($team)
{
	/* Display header */
	echo "
		<tr>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Team Name</strong></td>
			<td class='col-lg-3 col-md-3 col-sm-3'><strong>Wins</strong></td>
			<td class='col-lg-3 col-md-3 col-sm-3'><strong>Losses</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>LCS</strong></td>
		</tr>";

	/* Display first row */
	echo "<tr>";
		echo "<td class='col-lg-4 col-md-4 col-sm-2 col-xs-2'>".$team->team_name."</td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->wins."</td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->losses."</td>";
		if ($team->lcs == 1)
			$lcs = "Yes";
		else
			$lcs = "No";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$lcs."</td>";
	echo "</tr>";
	echo "</table>";
	echo "<br><br>";
	/* BANNER FOR ROSTER? */
	echo "<table class='table table-striped'>";
	echo "
		<tr>
			<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><strong>Top</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><strong>Mid</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><strong>Jungler</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><strong>Marksman</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><strong>Support</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1 col-xs-1'><strong>Sub 1</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1 col-xs-1'><strong>Sub 2</strong></td>
		</tr>";
	/* Second Row of values */
	echo"<tr>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->top."</td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->mid."</td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->jng."</td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->adc."</td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$team->sup."</td>";
		/* Correct for empty subs */
		echo "<td class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>".$team->sub1."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>".$team->sub2."</td>";
	echo "</tr>";
}

/* close PDO and database connection */
$db = NULL;
?>
	</table>
	<br>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default" onclick="loadEdit()">Edit Team</button>
	</span>
</div>
<script src="bootstrap.min.js"></script>
</body>
<script>
function loadEdit()
{
	/* for load the edit team page */
	var team = <?php echo json_encode($team); ?>;
	var teamLocation = "editteam.php?team=" + team;
	window.location=teamLocation;
}
</script>
</html>
