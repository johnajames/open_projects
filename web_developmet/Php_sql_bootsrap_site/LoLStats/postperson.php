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
if (isset($_POST['name']))
{
	$name = htmlspecialchars($_POST['name']);
}
if (isset($_POST['fname']))
{
	$fname = htmlspecialchars($_POST['fname']);
}
if (isset($_POST['lname']))
{
	$lname = ($_POST['lname']);
}
if (isset($_POST['role']))
{
	$role = ($_POST['role']);
}

if (isset($_POST['gpm']))
{
	if ($_POST['gpm'] == 0)
		$gpm === NULL;
	else
		$gpm = ($_POST['gpm']);
}

if (isset($_POST['cs']))
{
	if ($_POST['cs'] == 0)
		$cs === NULL;
	else
		$cs = ($_POST['cs']);
}

if (isset($_POST['kda']))
{
	if ($_POST['kda'] == 0)
		$kda === NULL;
	else
		$kda = ($_POST['kda']);
}
try {
	/* Prepared statement, no injections */
	$sth = $sql->prepare("
		INSERT INTO people (summoner_name, first_name, last_name, role, gpm, cs, kda)
		VALUES (:name, :fname, :lname, :role, :gpm, :cs, :kda)");
	/* Bind parameters to insert into proper places */
	$sth->bindParam(":name", $name);
	$sth->bindParam(":fname", $fname);
	$sth->bindParam(":lname", $lname);
	$sth->bindParam(":role", $role);
	$sth->bindParam(":gpm", $gpm);
	$sth->bindParam(":cs", $cs);
	$sth->bindParam(":kda", $kda);

	/* Execute the INSERT */
	$sth->execute();
} catch(PDOException $e) {
	echo $e->getMessage();
}
/* close PDO and database connection */
$db = NULL;
?>
