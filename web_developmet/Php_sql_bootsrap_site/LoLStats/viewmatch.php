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
	<title>LoL-DB : View Match</title>
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
	<h2>View Match</h2>
	<table class='table table-striped'>
		<tr>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Length</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Red Team</strong></td>
			<td class='col-lg-3 col-md-1 col-sm-1'><strong>Red Gold</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Blue Team</strong></td>
			<td class='col-lg-3 col-md-1 col-sm-1'><strong>Blue Gold</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong></strong></td>
		</tr>
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
if (isset($_GET['match']))
{
	$match = $_GET['match'];
}
//$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	/* display team information */
	$sth = $sql->query("
		SELECT games.game_id, win.team_name AS winner,
		T1.team_name AS red_team, games.red_gold,
		T2.team_name AS blue_team, games.blue_gold,
		games.length FROM games
		INNER JOIN teams AS T1 ON games.red_team = T1.team_id
		INNER JOIN teams AS T2 ON games.blue_team = T2.team_id
		INNER JOIN teams win ON win.team_id = games.winner
		WHERE games.match_id=".$match."");
		$sth->setFetchMode(PDO::FETCH_OBJ);
		while($game = $sth->fetch())
		{
			/* pass results of query to display */
			displayGame($game);
		}
} catch(PDOException $e) {
	echo $e->getMessage();
}
function displayGame($game)
{
	/* Display header */
	echo "<tr>";
		echo "<td class='col-lg-2 col-md-1 col-sm-1'>".$game->length."</td>";
		echo "<td class='col-lg-2 col-md-1 col-sm-1'>".$game->red_team."</td>";
		echo "<td class='col-lg-3 col-md-1 col-sm-1'>".$game->red_gold."</td>";
		echo "<td class='col-lg-2 col-md-1 col-sm-1'>".$game->blue_team."</td>";
		echo "<td class='col-lg-3 col-md-1 col-sm-1'>".$game->blue_gold."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>
					<span class='input-group-btn'>
						<button type='submit' id='submit' class='btn btn-default' onclick='loadGame(".$game->game_id.")'>View</button>
					</span>
				</td>";
	echo "</tr>";
}

/* close PDO and database connection */
$sql = NULL;
?>
	</table>
	<br>
</div>

<!-- footer container -->
      <section class="container">
        <footer class="row">
          <nav class="col-lg-12"> <!-- start of breadcrumb navigation -->
            <ul class="breadcrumb">
              <li><a href=""> </a></li>
              <li><a href=""> </a></li>
              <li><a href=""> </a></li>
            </ul>
          </nav>
        </footer> <!-- end footer -->
      </section><!-- close footer section -->


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
