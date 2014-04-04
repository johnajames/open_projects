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
	<title>LoL-DB : Add Gamelog</title>
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
<!-- load database information -->
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

/* call this page with ?gameId=X */
/* pull teams with query */
$gameId = $_GET["gameId"];
echo "<div>$gameId</div>";

$sth = $sql->query("
			SELECT red_team, blue_team FROM games
			WHERE game_id=".$gameId."");
$sth->setFetchMode(PDO::FETCH_OBJ);

$obj = $sth->fetch();
$team1 = $obj->blue_team;
$team2 = $obj->red_team;

/* Returns the id number of the person and their summoner name */
$sth = $sql->query("
			SELECT team_id, team_name, top, mid, jungler, marksman, support,
			P1.summoner_name AS ppl1,
			P2.summoner_name AS ppl2,
			P3.summoner_name AS ppl3,
			P4.summoner_name AS ppl4,
			P5.summoner_name AS ppl5
			FROM teams
			INNER JOIN people as P1 ON P1.ppl_id = top
			INNER JOIN people as P2 ON P2.ppl_id = mid
			INNER JOIN people as P3 ON P3.ppl_id = jungler
			INNER JOIN people as P4 ON P4.ppl_id = marksman
			INNER JOIN people as P5 ON P5.ppl_id = support
			WHERE team_id=$team1
			OR team_id=$team2
			"); 
$sth->setFetchMode(PDO::FETCH_OBJ);

$players = array();
while ($obj = $sth->fetch())
{
	/* add teams as options */
	array_push($players, $obj);
	/* add people as options */
}

/* closes database */
$sql = NULL;

function listPlayers($players)
{
	//echo "<select name='$name'>";
	foreach($players as $player)
	{
		echo "<option value=".$player->top.">".$player->ppl1."</option>";
		echo "<option value=".$player->mid.">".$player->ppl2."</option>";
		echo "<option value=".$player->jungler.">".$player->ppl3."</option>";
		echo "<option value=".$player->marksman.">".$player->ppl4."</option>";
		echo "<option value=".$player->support.">".$player->ppl5."</option>";
	}
	//echo "</select>";
}

?>
<!-- database information loaded, build rest of page -->
    <!-- enclosing form portion in container for proper margins and padding -->
<form method="post" id="events">
<div class="container" style="text-align:center">    
    <!-- Using Bootstrap Cols and rows to separate content -->
	<h2>Events Entry Form</h2>
	<table class="table table-striped">
		<tr>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Time (hh:mm:ss)</strong></td>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Team</strong></td>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Objective</strong></td>
		</tr>
		<tr>
			<!-- set col btstrp col sizes -->
			<?php echo "<input name='gameId' class='hidden' value=".$gameId.">"; ?>
			<td class="col-lg-4 col-md-4 col-sm-4"><input type="text" name="time" id="time" maxlength="45"></td>
			<!-- input for team -->
			<td class="col-lg-4 col-md-4 col-sm-4">
				<select class="team" name="team" id="team">
					<?php
						echo "<option value='$team1'>".$players[0]->team_name."</option>";
						echo "<option value='$team2'>".$players[1]->team_name."</option>";
					?>
				</select>
			</td>
			<td class='col-lg-4 col-md-4 col-sm-4'>
				<select class="objective" name="objective" id="objective">
					<option value="monsters">Neutral Minions</option>
					<option value="towers">Tower</option>
					<option value="inhibitors">Inhibitor</option>
					<option value="buffs">Buff</option>
					<option value="kills">Kill</option>
				</select>
			</td>
			</tr>
	<!-- minions -->
		</table>
		<table class="table table-striped"  style="display:none" id="minions">
		<tr>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Player</strong></td>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Monster</strong></td>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Side</strong></td>
		</tr>
		<tr>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<select class="minionplayer" name="minionplayer" id="minionplayer">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<select class="minions" name="minions" id="minions">
					<option value="wright">Wright</option>
					<option value="wolves">Wolves</option>
					<option value="wraith">Wraiths</option>
					<option value="golem">Golems</option>
					<option value="drake">Drake</option>
					<option value="baron">Baron</option>
				</select>
			</td>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<input type="radio" name="minionside" value=1>Blue
				<input type="radio" name="minionside" value=2>Red
			</td>
		</tr>
		
		<!-- Towers -->
		</table>
		<table class="table table-striped" style="display:none" id="towers">
		<tr>
			<td class="col-lg-3 col-md-3 col-sm-3"><strong>Player</strong></td>
			<td class="col-lg-3 col-md-3 col-sm-3"><strong>Tower Tier</strong></td>
			<td class="col-lg-3 col-md-3 col-sm-3"><strong>Side</strong></td>
			<td class="col-lg-3 col-md-3 col-sm-3"><strong>Tower Location</strong></td>
		</tr>
		<tr>
			<td class="col-lg-3 col-md-3 col-sm-3">
				<select class="towerplayer" name="towerplayer" id="towerplayer">
					<!--<option>---</option>-->
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-3 col-md-3 col-sm-3">
				<select class="tier" name="tier" id="tier">
					<option value="outer">Outer</option>
					<option value="inner">Middle</option>
					<option value="inhib">Inhibitor</option>
					<option value="nexus">Nexus</option>
				</select>
			</td>
			<td class="col-lg-3 col-md-3 col-sm-3">
				<input type="radio" name="towerside" value=1>Blue
				<input type="radio" name="towerside" value=2>Red
			</td>
			<td class="col-lg-3 col-md-3 col-sm-3">
				<select class="lanelocation" name="lanelocation" id="lanelocation">
					<option value="top">Top</option>
					<option value="mid">Middle</option>
					<option value="bot">Bottom</option>
				</select>
			</td>
		</tr>
		<!-- Buffs -->
		</table>
		<table class="table table-striped" style="display:none" id="buffs">
		<tr>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Player</strong></td>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Buff</strong></td>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Side</strong></td>
		</tr>
		<tr>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<select class="buffplayer" name="buffplayer" id="buffplayer">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<input type="radio" name="buff" value="blue">Blue Buff
				<input type="radio" name="buff" value="red">Red Buff
			</td>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<input type="radio" name="buffside" value="blue">Blue Side
				<input type="radio" name="buffside" value="red">Red Side
			</td>
		</tr>
		<!-- Inhibitors -->
		</table>
		<table class="table table-striped" style="display:none" id="inhibs">
		<tr>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Player</strong></td>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Inhibitor</strong></td>
			<td class="col-lg-4 col-md-4 col-sm-4"><strong>Side</strong></td>
		</tr>
		<tr>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<select class="inhibplayer" name="inhibplayer" id="inhibplayer">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<select class="inhiblane" name="inhiblane" id="inhiblane">
					<option value="top">Top</option>
					<option value="mid">Middle</option>
					<option value="bot">Bottom</option>
				</select>
			</td>
			<td class="col-lg-4 col-md-4 col-sm-4">
				<input type="radio" name="inhibside" value="blue">Blue Inhib
				<input type="radio" name="inhibside" value="red">Red Inhib
			</td>
		</tr>
		<!-- Kills -->
		</table>
		<table class="table table-striped" style="display:none" id="kill">
		<tr>
			<td class="col-lg-1 col-md-1 col-sm-1"><strong>Primary</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1"><strong>Assist</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1"><strong>Assist</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1"><strong>Assist</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1"><strong>Assist</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1"><strong>Death</strong></td>
		</tr>
		<tr>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="primarykill">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="assist1">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="assist2">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="assist3">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="assist4">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="death">
					<option value='0'>----</option>
					<?php listPlayers($players); ?>
				</select>
			</td>
		</tr>
		</tr>
	</table>
<br>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default" onClick="postAJAX()">Add Event</button>
	</span>
</div>
</form>
<!-- ends data submission table -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
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
$(".objective")
	.change(function(){
		$(".objective option:selected").each(function() {
			/* hide/show different functions */
			var obj = $(".objective").find(":selected").text();
			showTable(obj);
		});
	})
	.change();
	
function showTable(objective)
{
	//alert(objective);
	if (objective == "Neutral Minions")
	{
		$("#minions").show();
		$("#towers").hide();
		$("#inhibs").hide();
		$("#buffs").hide();
		$("#kill").hide();
	}
	if (objective == "Tower")
	{
		$("#minions").hide();
		$("#towers").show();
		$("#inhibs").hide();
		$("#buffs").hide();
		$("#kill").hide();
	}
	if (objective == "Inhibitor")
	{
		$("#minions").hide();
		$("#towers").hide();
		$("#inhibs").show();
		$("#buffs").hide();
		$("#kill").hide();
	}
	if (objective == "Buff")
	{
		$("#minions").hide();
		$("#towers").hide();
		$("#inhibs").hide();
		$("#buffs").show();
		$("#kill").hide();
	}
	if (objective == "Kill")
	{
		$("#minions").hide();
		$("#towers").hide();
		$("#inhibs").hide();
		$("#buffs").hide();
		$("#kill").show();
	}
}

function postAJAX()
{
	/* for ajax error, success, complete */
	$(function(){
	$("#events").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var post_url = "postgamelog.php";
		var post_data = form.serialize();
		$.ajax({
			type: "POST",
			url: post_url,
			data: post_data,
			success: function(output){
				/* Do something on success */
				alert("Success");
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