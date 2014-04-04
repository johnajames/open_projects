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
	<title>LoL-DB : Add Team</title>
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

<!--
	To dos:
	-Make it pretty
--> 
    <!-- Using Bootstrap Cols and rows to separate content -->
	<h2>Team Data Entry Form</h2>
	<table class="table table-striped">
		<tr>
			<td class='col-lg-4 col-md-4 col-sm-4'><strong>Team Name</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Wins</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Losses</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>LCS</strong></td>
			<td class='col-lg-2 col-md-2 col-sm-2'><strong>Region</strong></td>
		</tr>
		<tr>
			<!-- set col btstrp col sizes -->
			<form method="post" id="teams">
			<td class="col-lg-4 col-md-3 col-sm-1"><input type="text" name="teamname" id="teamName" maxlength="45"></td>
			<td class="col-lg-2 col-md-2 col-sm-1"><input type="text" name="win" id="wins" maxlength="3"></td>
			<td class="col-lg-2 col-md-2 col-sm-1"><input type="text" name="loss" id="losses" maxlength="3"></td>
			<td class="col-lg-2 col-md-2 col-sm-1"><input type="radio" name="lcs" value="1">Yes  <input type="radio" name="lcs" value="0"> No</td>
			<td class="col-lg-1 col-md-1 col-sm-1">
				<select name="region" id="region">
					<option value="NA">North America</option>
					<option value="EU">Europe</option>
					<option value="KR">Korea</option>
					<option value="CH">China</option>
					<option value="OCE">Oceania</option>
					<option value="SA">South American</option>
				</select>
			</td>
		<tr>
	</table>
	<br><br>
	<table class="table table-striped">
		<tr>
			<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><strong>Top Laner</strong></td>
			<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><strong>Mid Laner</strong></td>
			<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><strong>Jungler</strong></td>
			<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><strong>Marksman</strong></td>
			<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><strong>Support</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><strong>Sub 1</strong></td>
			<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><strong>Sub 2</strong></td>
		</tr>
<?php
/* create PDO for MySQL access */
try {
	$sql = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
	echo $e->getMessage();
}

/* Returns the id number of the person and their summoner name */
$sth = $sql->query("SELECT ppl_id, summoner_name FROM people ORDER BY summoner_name ASC");
$sth->setFetchMode(PDO::FETCH_OBJ);
/* to hold the list of summoners returned from the query */
$summoners = array();

while ($obj = $sth->fetch())
{
	array_push($summoners, $obj); // add names
}
/* add selections to the table */
echo "<tr>";
addSelection($summoners, "top");
addSelection($summoners, "mid");
addSelection($summoners, "jng");
addSelection($summoners, "adc");
addSelection($summoners, "sup");
addSelection($summoners, "sub1");
addSelection($summoners, "sub2");
echo "</tr>";
/* creates an option for every summoner found in the table */
function addSelection($summoners, $lane)
{
	echo "<td class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>";
	echo "<select name='".$lane."' id='".$lane."'>";
	/* correct for sub1 and sub2 possibly being null */
	if($lane == "sub1" || $lane =="sub2")
		echo "<option value='0'>None</option>";
	foreach($summoners as $players)
	{
		echo "<option value='".$players->ppl_id."'>".$players->summoner_name."</option>";
	}
	echo "</select>";
	echo "</td>";
}	
/* closes database */
$sql = NULL;
?>
</table>
<br>
	<span class="input-group-btn">
		<button type="submit" id="submit" class="btn btn-default" onclick="postAJAX()">Add Team</button>
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
function postAJAX()
{
	/* for ajax error, success, complete */
	$(function(){
	$("#teams").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var post_url = "postteam.php";
		var post_data = form.serialize();
		$.ajax({
			type: "POST",
			url: post_url,
			data: post_data,
			success: function(){
				/* Do something on success */
				alert("Data uploaded");
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
