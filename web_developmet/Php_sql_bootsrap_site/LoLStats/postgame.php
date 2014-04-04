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

/* insert into games database */

if (isset($_POST['length']))
{
	$length = htmlspecialchars($_POST['length']);
}
if (isset($_POST['winner']))
{
	$winner = htmlspecialchars($_POST['winner']);
}
if (isset($_POST['redteam']))
{
	$redteam = htmlspecialchars($_POST['redteam']);
}
if (isset($_POST['redgold']))
{
	$redgold = htmlspecialchars($_POST['redgold']);
}
if (isset($_POST['blueteam']))
{
	$blueteam = htmlspecialchars($_POST['blueteam']);
}
if (isset($_POST['bluegold']))
{
	$bluegold = htmlspecialchars($_POST['bluegold']);
}

$match = $_POST["match"];

try {
	$sth = $sql->prepare("
		INSERT INTO games (winner, red_team, red_gold, blue_team, blue_gold, length, match_id)
		VALUES (:winner, :red_team, :red_gold, :blue_team, :blue_gold, :length, :match_id)");
		$sth->bindParam(":winner", $winner);
		$sth->bindParam(":red_team", $redteam);
		$sth->bindParam(":red_gold", $redgold);
		$sth->bindParam(":blue_team", $blueteam);
		$sth->bindParam(":blue_gold", $bluegold);
		$sth->bindParam(":length", $length);
		$sth->bindParam(":match_id", $match);
		
		$sth->execute();
		$gameId = $sql->lastInsertId("game_id");
} catch(PDOException $e) {
	echo $e->getMessage();
}

/* load add gamelog */

header('Location: addgamelog.php?gameId='.$gameId.'');

/* close PDO and database connection */
$db = NULL;
?>
