<?php
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
//$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
	/* display team information */
	$sth = $sql->query("
			SELECT e.time AS clock, t.team_name AS team, o.objective AS obj, o.side AS side, o.lane AS lane,
			p1.summoner_name AS main, p2.summoner_name AS assist1,
			p3.summoner_name AS assist2, p4.summoner_name AS assist3,
			p5.summoner_name AS assist4, d.summoner_name AS death
			FROM events AS e
			INNER JOIN game_events ON game_events.event_id = e.event_id
			INNER JOIN teams AS t ON t.team_id = e.team
			INNER JOIN objective AS o ON o.obj_id = e.objective
			INNER JOIN people AS p1 ON p1.ppl_id = e.primary_person
			LEFT OUTER JOIN people AS p2 ON p2.ppl_id = e.first_assist
			LEFT OUTER JOIN people AS p3 ON p3.ppl_id = e.second_assist
			LEFT OUTER JOIN people AS p4 ON p4.ppl_id = e.third_assist
			LEFT OUTER JOIN people AS p5 ON p5.ppl_id = e.fourthassist
			LEFT OUTER JOIN people AS d ON d.ppl_id = e.death
			WHERE game_events.game_id=1");
		$sth->setFetchMode(PDO::FETCH_OBJ);
		while($obj = $sth->fetch())
		{
		/*echo "
			<tr>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->clock."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->team."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->obj."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->side."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->lane."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->main."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->assist1."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->assist2."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->assist3."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->assist4."</td>
				<td class='col-lg-1 col-md-1 col-sm-1'>".$obj->death."</td>
			</tr>";*/
			print_r($obj);
			/* pass results of query to display */
			//displayEvent($obj);
		}
} catch(PDOException $e) {
	echo $e->getMessage();
}
?>