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
if (isset($_POST['teamname']))
{
	$name = htmlspecialchars($_POST['teamname']);
}
if (isset($_POST['win']))
{
	$wins = $_POST['win'];
}
if (isset($_POST['loss']))
{
	$losses = $_POST['loss'];
}
if (isset($_POST['lcs']))
{
	$lcs = $_POST['lcs'];
}
if (isset($_POST['region']))
{
	$region = htmlspecialchars($_POST['region']);
}
if (isset($_POST['top']))
{
	$top = $_POST['top'];
}
if (isset($_POST['mid']))
{
	$mid = $_POST['mid'];
}
if (isset($_POST['jng']))
{
	$jungler = $_POST['jng'];
}
if (isset($_POST['adc']))
{
	$marksman = $_POST['adc'];
}
if (isset($_POST['sup']))
{
	$support = $_POST['sup'];
}
/* corrects for NULL values */
if (isset($_POST['sub1']))
{
	if($_POST['sub1'] == 0) {
		$sub1 === NULL;
	} else {
		$sub1 = $_POST['sub1'];
	}
}
if (isset($_POST['sub2']))
{
	if($_POST['sub2'] == 0) {
		$sub2 === NULL;
	} else {
		$sub1 = $_POST['sub2'];
	}
}
try {
	/* Prepared statement, no injections */
	$sth = $sql->prepare("
		INSERT INTO teams (team_name, wins, losses, lcs, region, top, mid, jungler, marksman, support, sub1, sub2)
		VALUES (:name, :wins, :losses, :lcs, :region, :top, :mid, :jungler, :marksman, :support, :sub1, :sub2)");
	/* Bind parameters to insert into proper places */
	$sth->bindParam(":name", $name);
	$sth->bindParam(":wins", $wins);
	$sth->bindParam(":losses", $losses);
	$sth->bindParam(":lcs", $lcs);
	$sth->bindParam(":region", $region);
	$sth->bindParam(":top", $top);
	$sth->bindParam(":mid", $mid);
	$sth->bindParam(":jungler", $jungler);
	$sth->bindParam(":marksman", $marksman);
	$sth->bindParam(":support", $support);
	$sth->bindParam(":sub1", $sub1);
	$sth->bindParam(":sub2", $sub2);

	/* Execute the INSERT */
	$sth->execute();
} catch(PDOException $e) {
	echo $e->getMessage();
}
/* close PDO and database connection */
$db = NULL;
?>
