<?php

/*
 *	TO DO LIST
 *	-do not post if isset(X) returns false
 *	-create a log to write caught errors
 *	-return ajax call with error
 */
 
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

$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* Clean data coming from form */
if (isset($_POST['eventname']))
{
	$event = htmlspecialchars($_POST['eventname']);
}
if (isset($_POST['bestof']))
{
	$bestof = htmlspecialchars($_POST['bestof']);
}
if (isset($_POST['team1']))
{
	$team1 = ($_POST['team1']);
}
if (isset($_POST['team2']))
{
	$team2 = ($_POST['team2']);
}
if (isset($_POST['winner']))
{
	if ($_POST['winner'] == 0)
		$winner === NULL;
	else
		$winner = ($_POST['winner']);
}
try {
	/* Prepared statement, no injections */
	$sth = $sql->prepare("
		INSERT INTO matches (event, bestof, team1, team2, winner)
		VALUES (:event, :bestof, :team1, :team2, :winner)");
	/* Bind parameters to insert into proper places */
	$sth->bindParam(":event", $event);
	$sth->bindParam(":bestof", $bestof);
	$sth->bindParam(":team1", $team1);
	$sth->bindParam(":team2", $team2);
	$sth->bindParam(":winner", $winner);

	/* Execute the INSERT */
	$sth->execute();
} catch(PDOException $e) {
	echo $e->getMessage();
}

$matchId = $sql->lastInsertId("match_id"); // get last id
//echo $matchId;
header('Location: addgame.php?match='.$matchId.'');
/* close PDO and database connection */
$db = NULL;
?>
