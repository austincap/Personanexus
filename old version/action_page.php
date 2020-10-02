<?php
	$GroupName = $_POST["groupname"];
	//get entire POST input including groupname but array_slice it off later
	$RawAjaxInput = file_get_contents('php://input');
	//find each input personas from the raw Ajax POST data
	$personas = array_slice(preg_split("/(&personas=)/", $RawAjaxInput),1);
	//count the personas in the group
	$NumMembers = count($personas);

	$mysqli_link = mysqli_connect("localhost", "root", "", "test");


	/////need semicolons in quotes
	$the_query = "INSERT INTO `pglsql` (`GroupName`, `NumMembers`) VALUES ('" . $GroupName . "', '" . $NumMembers . "');";
	//echo $the_query;
	echo "<br/>";
	mysqli_query($mysqli_link, $the_query);

	//get recently create GroupID (the largest one cause of auto_increment)
	$the_query = "SELECT `GroupID` FROM `pglsql` ORDER BY `GroupID` DESC LIMIT 1;";
	//echo $the_query;
	echo "<br/>";
	$mysqli_result = mysqli_query($mysqli_link, $the_query);

	if (!$mysqli_result) {
		die('Invalid query: ' . mysqli_connect_errno());
	} else {
		while($row = $mysqli_result->fetch_assoc()){

			//get newly created GroupID
			$GroupID = (int) $row["GroupID"];
			//then insert it, along with each persona name in the list, into plsql
			foreach ($personas as $persona) {
				$the_query = "INSERT INTO `plsql` (`PersonaName`, `GroupID`) VALUES ('" . $persona . "', " . $GroupID . ");";
				//echo $the_query;
				echo "<br/>";
				mysqli_query($mysqli_link, $the_query);
			}

		};
	}

?>

OK!