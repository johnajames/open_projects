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
	<title>LoL-DB : Add Match</title>
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
    <!-- Using Bootstrap Cols and rows to separate content -->
	<h2>Match Entry Form</h2>
	<table class="table table-striped">
		<tr>
			<td class='col-lg-3 col-md-3 col-sm-3'><strong>Event Name</strong></td>
			<td class='col-lg-3 col-md-3 col-sm-3'><strong>Best of</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Team 1</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Team 2</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Winner</strong></td>
		</tr>
		<tr>
			<!-- set col btstrp col sizes -->
			<form method="post" id="teams" action="postmatch.php">
			<td class="col-lg-3 col-md-3 col-sm-1"><input type="text" name="eventname" id="event" maxlength="45"></td>
			<td class="col-lg-3 col-md-3 col-sm-1"><input type="text" name="bestof" id="bestof" maxlength="1"></td>
<!-- pull teams to make a selection on -->
<?php
/* create PDO for MySQL access */
try {
	$sql = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
	echo $e->getMessage();
}

/* Returns the id number of the person and their summoner name */
$sth = $sql->query("SELECT team_id, team_name FROM teams");
$sth->setFetchMode(PDO::FETCH_OBJ);
/* to hold the list of teams returned from the query */
$teams = array();

while ($obj = $sth->fetch())
{
	array_push($teams, $obj); // add names
}
addTeam($teams, "team1");
addTeam($teams, "team2");
addWinner();
/* create a selection for winners */
echo "</tr>";

/* creates an option for every summoner found in the table */
function addTeam($teams, $which)
{
	echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
		echo "<select class='selectTeam' name='".$which."' id='".$which."'>";
		foreach($teams as $team)
		{
			echo "<option value='".$team->team_id."'>".$team->team_name."</option>";
		}
		echo "</select>";
	echo "</td>";
}

function addWinner()
{
	echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
		echo "<select class='winner' name='winner' id='winner'>";
			echo "<option value='0'>Not decided</option>";
			echo "<option value='win1'>-----</option>";
			echo "<option value='win2'>-----</option>";
		echo "</select>";
	echo "</td>";
}
/* closes database */
$sql = NULL;
?>
</table>
<br>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default">Add Match</button>
	</span>
</form>
<!-- ends data submission table -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
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
/* Change the values of the winner option, team1 on top, team2 on bot */
$(".selectTeam")
	.change(function(){
		$(".selectTeam option:selected").each(function() {
			/* load contents of selected team 1 into JS variables, using JS and jQuery */
			var team1ID = document.getElementById('team1').value; // holds the id for team 1
			var team1Name = $("#team1 option[value="+team1ID+"]").text(); // name for team 1
			
			/* load contents of selected team 2 into JS variables, using JS and jQuery */
			var team2ID = document.getElementById('team2').value; // holds the id for team 2
			var team2Name = $("#team2 option[value="+team2ID+"]").text(); // name for team 2

			/* update values of winner options */
			document.getElementById('winner').options[1].text = team1Name;
			document.getElementById('winner').options[1].value = team1ID;

			document.getElementById('winner').options[2].text = team2Name;
			document.getElementById('winner').options[2].value = team2ID;
		});
	})
	.change();

/* function postAJAX()
{
	for ajax error, success, complete
	$(function(){
	$("#teams").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var post_url = "postmatch.php";
		var post_data = form.serialize();
		$.ajax({
			type: "POST",
			url: post_url,
			data: post_data,
			success: function(output){
				Do something on success
				var gameLocation = "addgame.php?match=" + output;
				loadPage(gameLocation);
			},
			error: function() {
				send to an error log
				alert("An error has occurred");
			},
			complete: function(){
				do something on complete, runs after error and success
				location.reload();
			}
		})
	});
	})
}

function loadPage(url)
{
	window.location=url;
} */
</script>
</html>