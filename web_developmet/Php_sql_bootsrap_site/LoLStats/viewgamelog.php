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
	<title>LoL-DB : View Game</title>
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
          <a class="navbar-brand" href="#">StatTrack</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">LoL News</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="landing.php">Stat Tracker</a></li>
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
	<h2>View Game</h2>
	<table class='table table-striped'>
		<tr>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Time</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Team</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Object</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Side</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Lane</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Primary</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Assist</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Assist</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Assist</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Assist</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'><strong>Death</strong></td>
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
if (isset($_GET['game']))
{
	$game = $_GET['game'];
}
//$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	/* display team information */
	$sth = $sql->query("
			SELECT e.time AS clock, t.team_name AS team, o.objective AS obj, o.side AS side, o.lane AS lane,
			p1.summoner_name AS main, p2.summoner_name AS assist1,
			p3.summoner_name AS assist2, p4.summoner_name AS assist3,
			p5.summoner_name AS assist4, d.summoner_name AS death
			FROM events AS e
			INNER JOIN game_events ON game_events.event_id = e.event_id
			INNER JOIN teams AS t ON t.team_id = e.team
			INNER JOIN objective AS o ON o.obj_id = e.objective
			INNER JOIN people AS p1 ON p1.ppl_id = e.primary_person
			LEFT OUTER JOIN people AS p2 ON p2.ppl_id = e.first_assist
			LEFT OUTER JOIN people AS p3 ON p3.ppl_id = e.second_assist
			LEFT OUTER JOIN people AS p4 ON p4.ppl_id = e.third_assist
			LEFT OUTER JOIN people AS p5 ON p5.ppl_id = e.fourthassist
			LEFT OUTER JOIN people AS d ON d.ppl_id = e.death
			WHERE game_events.game_id=".$game."
			ORDER BY e.time");
		$sth->setFetchMode(PDO::FETCH_OBJ);
		while($event = $sth->fetch())
		{
			/* pass results of query to display */
			displayEvent($event);
		}
} catch(PDOException $e) {
	echo $e->getMessage();
}

function displayEvent($event)
{
	/* Display header */
	echo "<tr>";
		echo"<td class='col-lg-1 col-md-1 col-sm-1'>".$event->clock."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->team."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->obj."</td>";
		if ($event->side == 1)
			$side = "Blue";
		else if ($event->side == 2)
			$side = "Red";
		else
			$side = NULL;
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$side."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->lane."</td>";
		
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->main."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->assist1."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->assist2."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->assist3."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->assist4."</td>";
		echo "<td class='col-lg-1 col-md-1 col-sm-1'>".$event->death."</td>";
	echo "</tr>";
}

/* close PDO and database connection */
$sql = NULL;
?>
	</table>
	<br>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default" onclick="loadOutcome()">View Outcome</button>
	</span>
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
function loadOutcome()
{
	/* for load the edit team page */
	var game = <?php echo json_encode($game); ?>;
	var gameLocation = "viewoutcome.php?game=" + game;
	window.location=gameLocation;
}
</script>
</html>
