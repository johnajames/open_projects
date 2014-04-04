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
	<title>LoL-DB : Edit Team</title>
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
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Sign In</a></li>
				<li><a href="#contact">Create Account</a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>
<!-- end of navigation bar -->    
<br>
<br>
<div class='container' style='text-align:center'>
	<form method='post' id='teams'>
<!-- pull and display team information -->
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
/* grab variable that details which team to load */
if (isset($_GET['team']))
{
	$team = $_GET['team'];
}
//$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	/* display team information */
	$sth = $sql->query("
		SELECT t.team_name, t.wins, t.losses, t.lcs, t.region,
		P1.summoner_name AS top, P1.ppl_id,
		P2.summoner_name AS mid, P2.ppl_id,
		P3.summoner_name AS jng, P3.ppl_id,
	   	P4.summoner_name AS adc, P4.ppl_id,
		P5.summoner_name AS sup, P5.ppl_id,
		P6.summoner_name AS sub1, P6.ppl_id,
		P7.summoner_name AS sub2, P7.ppl_id
	   	FROM teams AS t
		LEFT OUTER JOIN people AS P1 ON P1.ppl_id = t.top
		LEFT OUTER JOIN people AS P2 ON P2.ppl_id = t.mid
		LEFT OUTER JOIN people AS P3 ON P3.ppl_id = t.jungler
		LEFT OUTER JOIN people AS P4 ON P4.ppl_id = t.marksman
		LEFT OUTER JOIN people AS P5 ON P5.ppl_id = t.support
		LEFT OUTER JOIN people AS P6 ON P6.ppl_id = t.sub1
		LEFT OUTER JOIN people AS P7 ON P7.ppl_id = t.sub2
		WHERE t.team_id=".$team."");
	$sth->setFetchMode(PDO::FETCH_OBJ);
	/* to hold the list of summoners returned from the query */
	/* run the query and fetch results */
	$current = $sth->fetch();
	/* hidden input that holds the current team as it's value */
	echo "<input name='teamid' class='hidden' value=".$team.">";
	displayTeam($current);
	
	/* update team selection, where people are populated via drop down, with the person that is current on team is first */
	$sth = $sql->query("SELECT ppl_id, summoner_name FROM people");
	$sth->setFetchMode(PDO::FETCH_OBJ);
	$summoners = array();
	while ($obj = $sth->fetch())
	{
		array_push($summoners, $obj);
	}
	/* header for the roster */
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
	echo "<tr>";
	/*  people selection in here */
		displayPeople($summoners, "top", $current->P1.ppl_id, $current->top);
		displayPeople($summoners, "mid", $current->P2.ppl_id, $current->mid);
		displayPeople($summoners, "jng", $current->P3.ppl_id, $current->jng);
		displayPeople($summoners, "adc", $current->P4.ppl_id, $current->adc);
		displayPeople($summoners, "sup", $current->P5.ppl_id, $current->sup);
		displayPeople($summoners, "sub1", $current->P6.ppl_id, $current->sub1);
		displayPeople($summoners, "sub2", $current->P7.ppl_id, $current->sub2);
	echo "</tr>";
	echo "</table>";
} catch(PDOException $e) {
	echo $e->getMessage();
}

function displayTeam($team)
{
	/* Display header */
	echo "<h2>Edit Team</h2>";
	echo "<table class='table table-striped'>";
	echo "
		<tr>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Team Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Wins</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Losses</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>LCS</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Region</strong></td>
		</tr>";

	/* Display first row */
	echo "<tr>";
		echo "<td class='col-lg-4 col-md-4 col-sm-2 col-xs-2'><input type='text' name='teamname' maxlength='45' value='".$team->team_name."'></td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><input type='text' name='win' id='wins' maxlength='3' value='".$team->wins."'></td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><input type='text' name='loss' id='losses' maxlength='3' value='".$team->losses."'></td>";
		echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
		/* select LCS boolean based on current status in database */
		if ($team->lcs == 1) {
			echo "<input type='radio' name='lcs' value='1' checked='checked'>Yes  <input type='radio' name='lcs' value='0'>No</td>";
		} else {
			echo "<input type='radio' name='lcs' value='1'>Yes  <input type='radio' name='lcs' value='0' checked='checked'>No</td>";
		}
		/* select region option based on results stored in database */
		echo "
			<td class='col-lg-1 col-md-1 col-sm-1'>
				<select name='region' id='region'>";
				if ($team->region == 'NA')	{
					echo "<option selected='selected' value='NA'>North America</option>";
				} else {
					echo "<option value='NA'>North America</option>";
				}
				if ($team->region == 'EU')	{
					echo "<option selected='selected' value='EU'>Europe</option>";
				} else {
					echo "<option value='EU'>Europe</option>";
				}
				if ($team->region == 'KR')	{
					echo "<option selected='selected' value='KR'>Korea</option>";
				} else {
					echo "<option value='KR'>Korea</option>";
				}
				if ($team->region == 'CH')	{
					echo "<option selected='selected' value='CH'>China</option>";
				} else {
					echo "<option value='CH'>China</option>";
				}
				if ($team->region == 'OCE')	{
					echo "<option selected='selected' value='OCE'>Oceania</option>";
				} else {
					echo "<option value='OCE'>Oceania</option>";
				}
				if ($team->region == 'SA')	{
					echo "<option selected='selected' value='SA'>South America</option>";
				} else {
					echo "<option value='SA'>North America</option>";
				}
		echo "</select>
			</td>";
	echo "</tr>";
	echo "</table>";
	echo "<br><br>";
}
/*	creates a drop down selection of people
 *	inputs: summoners as an object, lane as a string
 *			currentId as an int, currentLn as string
 */
function displayPeople($summoners, $lane, $currentId, $currentLn)
{
	echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
	echo "<select name='".$lane."' id='".$lane."'>";

	/* Lists current person on team first */
	echo "<option value='".$currentId."'>".$currentLn."</option>";
	foreach($summoners as $players)
	{
		/* ensures that current person on team is not listed twice */
		if ($players->ppl_id != $currentId)
			echo "<option value='".$players->ppl_id."'>".$players->summoner_name."</option>";
	}
	echo "</select>";
	echo "</td>";
}
/* close PDO and database connection */
$db = NULL;
?>
	<br>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default" onclick="postAJAX()">Update</button>
	</span>
</form>
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
		var post_url = "updateteam.php";
		var post_data = form.serialize();
		$.ajax({
			type: "POST",
			url: post_url,
			data: post_data,
			success: function(){
				/* Do something on success */
				alert("Data updated");
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
