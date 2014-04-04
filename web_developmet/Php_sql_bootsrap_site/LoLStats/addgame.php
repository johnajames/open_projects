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
	<title>LoL-DB : Add Game</title>
</head>
<body>
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
/* get the match info */
if (isset($_GET['match']))
{
	$match = $_GET['match'];
}

/* pull two teams info that was just posted */
/* match id is being passed from previous page */
/* Add match, then jump right to add gamelog, passing the just added gameId as a post/get? */

$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	/* display team information */
	$sth = $sql->query("
		SELECT T1.team_name AS t1Name, T1.team_id AS t1Id,
		T2.team_name AS t2Name, T2.team_id AS t2Id
		FROM matches
		INNER JOIN teams AS T1 ON T1.team_id = matches.team1
		INNER JOIN teams AS T2 ON T2.team_id = matches.team2
		WHERE matches.match_id=".$match."");
		$sth->setFetchMode(PDO::FETCH_OBJ);
	
	$teams = $sth->fetch();
	
} catch(PDOException $e) {
	echo $e->getMessage();
}
?>
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
	<h2>Add Game</h2>
	<form method="post" id="game" action="postgame.php">
	<?php echo "<input name='match' class='hidden' value=".$match.">"; ?>
	<table class='table table-striped'>
		<tr>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Length</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Winner</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Red Team</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Red Gold</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Blue Team</strong></td>
			<td class='col-lg-2 col-md-1 col-sm-1'><strong>Blue Gold</strong></td>
			<td class='col-lg-1 col-md-1 col-sm-1'></td>
		</tr>
		<tr>
			<td class='col-lg-2 col-md-1 col-sm-1'>
				<input type="text" name="length" id="length" maxlength="45">
			</td>
			<td class='col-lg-2 col-md-1 col-sm-1'>
				<!-- options for red team -->
				<?php addTeam($teams, "winner"); ?>
			</td>
			<td class='col-lg-2 col-md-1 col-sm-1'>
				<!-- options for red team -->
				<?php addTeam($teams, "redteam"); ?>
			</td>
			<td class='col-lg-2 col-md-1 col-sm-1'>
				<input tpye="text" name="redgold" id="redgold" maxlength="45">
			</td>
			<td class='col-lg-2 col-md-1 col-sm-1'>
				<!-- options for blue team -->
				<?php addTeam($teams, "blueteam"); ?>
			</td>
			<td class='col-lg-2 col-md-1 col-sm-1'>
				<input tpye="text" name="bluegold" id="bluegold" maxlength="45">
			</td>
			<td class='col-lg-1 col-md-1 col-sm-1'>
				<span class='input-group-btn'>
					<button type='submit' id='submit' class='btn btn-default'>Add Events</button>
				</span>
			</td>
		</tr>
	</table>
<?php
function addTeam($teams, $which)
{
	echo "<select class='selectTeam' name='".$which."' id='".$which."'>";
		echo "<option value='".$teams->t1Id."'>".$teams->t1Name."</option>";
		echo "<option value='".$teams->t2Id."'>".$teams->t2Name."</option>";
	echo "</select>";
}
?>
</form>
</div>
</body>
</html>
