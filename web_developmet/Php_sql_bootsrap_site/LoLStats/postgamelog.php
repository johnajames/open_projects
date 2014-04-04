<?php
class objective
{
	public $time;
	public $team;
	public $objective;
	public $player;
	public $assist1 = NULL;
	public $assist2 = NULL;
	public $assist3 = NULL;
	public $assist4 = NULL;
	public $death = NULL;
	public $gameId = NULL;
	
	public function postToEvents($sql)
	{
		$sth = $sql->prepare("
				INSERT INTO events (time, team, objective, primary_person, first_assist, second_assist, third_assist, fourthAssist, death)
				VALUES (:time, :team, :objective, :primary, :first, :second, :third, :fourth, :death)");
		$sth->bindParam(":time", $this->time);
		$sth->bindParam(":team", $this->team);
		$sth->bindParam(":objective", $this->objective);
		$sth->bindParam(":primary", $this->player);
		$sth->bindParam(":first", $this->assist1);
		$sth->bindParam(":second", $this->assist2);
		$sth->bindParam(":third", $this->assist3);
		$sth->bindParam(":fourth", $this->assist4);
		$sth->bindParam(":death", $this->death);
		
		try {
			$sth->execute();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}

		$eventId = $sql->lastInsertId("event_id"); // get last id
		
		$sth = $sql->prepare("
				INSERT INTO game_events (game_id, event_id)
				VALUES (:gameId, :eventId)");
		$sth->bindParam(":gameId", $this->gameId);
		$sth->bindParam(":eventId", $eventId);
		
		try {
			$sth->execute();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
}

$a = new objective;

$a->time = $_POST["time"];
$a->team = $_POST["team"];
$a->objective = NULL;
$a->player = NULL;
$a->gameId = $_POST["gameId"];

$objType = $_POST["objective"];
$side = NULL;

switch ($objType)
{
	case "monsters":
		postMinion($a);
		break;
	case "towers":
		postTower($a);
		break;
	case "inhibitors":
		postInhib($a);
		break;
	case "buffs":
		postBuff($a);
		break;
	case "kills":
		postKill($a);
		break;
}
//print_r($_POST);

function postMinion(&$obj)
{
	/* minions */
	$neutral = $_POST["minions"];
	$side = $_POST["minionside"];
	$obj->player = $_POST["minionplayer"];
	switch ($neutral)
	{
		case "wright":
			if ($side == 1)
				$obj->objective = 20;
			else
				$obj->objective = 42;
			break;
		case "wolves":
			if ($side == 1)
				$obj->objective = 19;
			else
				$obj->objective = 41;
			break;
		case "wraith":
			if ($side == 1)
				$obj->objective = 18;
			else
				$obj->objective = 40;
			break;
		case "golems":
			if ($side == 1)
				$obj->objective = 17;
			else
				$obj->objective = 39;
			break;
		case "drake":
			$obj->objective = 22;
			break;
		case "baron":
			$obj->objective = 21;
			break;
	}
}

/* towers */
function postTower(&$obj)
	{
	$obj->player = $_POST["towerplayer"];
	$side = $_POST["towerside"];
	$lane = $_POST["lanelocation"];
	$tier = $_POST["tier"];
	switch($tier)
	{
		case "outer":
			switch($lane)
			{
				case "top":
					if ($side == 1)
						$obj->objective = 1;
					else
						$obj->objective = 23;
					break;
				case "mid":
					if ($side == 1)
						$obj->objective = 4;
					else
						$obj->objective = 26;
					break;
				case "bot":
					if ($side == 1)
						$obj->objective = 7;
					else
						$obj->objective = 29;
					break;
			}
			break;
		case "inner":
			switch($lane)
			{
				case "top":
					if ($side == 1)
						$obj->objective = 2;
					else
						$obj->objective = 24;
					break;
				case "mid":
					if ($side == 1)
						$obj->objective = 5;
					else
						$obj->objective = 27;
					break;
				case "bot":
					if ($side == 1)
						$obj->objective = 8;
					else
						$obj->objective = 30;
					break;
			}
			break;
		case "inhib":
			switch($lane)
			{
				case "top":
					if ($side == 1)
						$obj->objective = 3;
					else
						$obj->objective = 25;
					break;
				case "mid":
					if ($side == 1)
						$obj->objective = 6;
					else
						$obj->objective = 28;
					break;
				case "bot":
					if ($side == 1)
						$obj->objective = 9;
					else
						$obj->objective = 31;
					break;
			}
			break;
		case "nexus":
			if ($side == 1)
				$obj->objective = 10;
			else
				$obj->objective = 32;
			break;
	}
}

function postBuff(&$obj)
{
	$obj->player = $_POST["buffplayer"];
	$buff = $_POST["buff"];
	$side = $_POST["buffside"];
	switch ($buff)
	{
		case "blue":
			if ($side == 1)
				$obj->objective = 15;
			else
				$obj->objective = 37;
			break;
		case "red":
			if ($side == 1)
				$obj->objective = 16;
			else
				$obj->objective = 38;
			break;
	}
}

function postInhib(&$obj)
{
	$obj->player = $_POST["inhibplayer"];
	$lane = $_POST["inhiblane"];
	$side = $_POST["inhibside"];
	switch ($lane)
	{
		case "top":
			if ($side == 1)
				$obj->objective = 12;
			else
				$obj->objective = 34;
			break;
		case "mid":
			if ($side == 1)
				$obj->objective = 13;
			else
				$obj->objective = 35;
			break;
		case "bot":
			if ($side == 1)
				$obj->objective = 14;
			else
				$obj->objective = 36;
			break;
	}
}
function postKill(&$obj)
{
	$obj->player = $_POST["primarykill"];
	$obj->assist1 = $_POST["assist1"];
	$obj->assist2 = $_POST["assist2"];
	$obj->assist3 = $_POST["assist3"];
	$obj->assist4 = $_POST["assist4"];
	$obj->death = $_POST["death"];
	$obj->objective = 43;
	
	/* correct for null values */
	if ($obj->assist1 == 0)
		$obj->assist1 === NULL;

	if ($obj->assist2 == 0)
		$obj->assist2 === NULL;

	if ($obj->assist3 == 0)
		$obj->assist3 === NULL;

	if ($obj->assist4 == 0)
		$obj->assist4 === NULL;
}


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

$a->postToEvents($sql);

$sql = NULL;
?>