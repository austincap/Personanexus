<?php
	$mysqli_link = mysqli_connect("localhost", "root", "", "test");

	/////need semicolons in quotes
	$the_query = "SELECT * FROM `plsql` ORDER BY RAND() LIMIT 1;";
	// echo $the_query;
	// echo "<br/>";
	$firstpersona = mysqli_query($mysqli_link, $the_query);

	$row = $firstpersona->fetch_assoc();
	$firstpersonaGroupID = (int) $row["GroupID"];
	// echo $firstpersonaGroupID;
	// echo "<br/>";
	$firstpersonaName = (string) $row["PersonaName"];
	// echo $firstpersonaName;
	// echo "<br/>";
	$firstpersonaID = (int) $row["PersonaID"];
	
	$the_query = "SELECT * FROM `plsql` WHERE (" . $firstpersonaGroupID . " != `GroupID`) ORDER BY RAND() LIMIT 1;";
	// echo $the_query;
	// echo "<br/>";

	$secondpersona = mysqli_query($mysqli_link, $the_query);
	$row = $secondpersona->fetch_assoc();
	$secondpersonaName = (string) $row["PersonaName"];
	// echo $secondpersonaName;
	// echo "<br/>";
	$secondpersonaGroupID = (int) $row["GroupID"];
	// echo $secondpersonaGroupID;
	// echo "<br/>";
	$secondpersonaID = (int) $row["PersonaID"];

	$the_query = "SELECT * FROM `pglsql` WHERE (`GroupID`=" . $firstpersonaGroupID . ");";
	$personaoneGroup = mysqli_query($mysqli_link, $the_query);
	$row = $personaoneGroup->fetch_assoc();
	$firstpersonaGroupName = (string) $row["GroupName"];
	// echo $firstpersonaGroupName;
	// echo "<br/>";

	$the_query = "SELECT * FROM `pglsql` WHERE (`GroupID`=" . $secondpersonaGroupID . ");";
	$personatwoGroup = mysqli_query($mysqli_link, $the_query);
	$row = $personatwoGroup->fetch_assoc();
	$secondpersonaGroupName = (string) $row["GroupName"];
	// echo $secondpersonaGroupName;
	// echo "<br/>";

	echo "Is the essence of '" . $firstpersonaName . "' similar to the essence of '" . $secondpersonaName . "'?";
	echo "<br/>";
	echo "('" . $firstpersonaName . "' is from group '" . $firstpersonaGroupName . "' and '" . $secondpersonaName . "' is from group '" . $secondpersonaGroupName . "')";



	//$mongo_connection = new Mongo('mongodb://austincapobianco:fucksluts@ds037244.mongolab.com:37244/personanexus');

	// $connecting_string = sprintf('mongodb://%s:%d/%s', 'ds037244.mongolab.com', 37244, 'personanexus');
	// $connection=new Mongo($connecting_string, array('austincapobianco'=>$username, 'fucksluts'=>$password));

	//$mongo_connection = new MongoClient("mongodb://@ds037244.mongolab.com:37244", array("username"=>"austincapobianco", "password"=>"fucksluts10", "db"=>"personanexus"));
	
////////REAL ONE ON EXTERNAL SERVER

	$uri = "mongodb://austincapobianco:fucksluts10@ds037244.mongolab.com:37244/personanexus";
	$client = new MongoClient($uri);
	$db = $client->selectDB("personanexus");
	// $rawVoteData = $db->rawVoteData;
	// $cursor = $rawVoteData->find(array(), array());

	// foreach($cursor as $doc) {
	//  	echo "<br/>";
	//  	echo $doc["yesvotes"];
	//  }




?>

<!DOCTYPE html>
<head>
<title>Contribute opinions</title>
</head>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<body>
<script type="text/javascript">
</script>

<br/>
<form action="?submitvote" method="post">
<input type="submit" name="submityes" value="yes">

<input type="submit" name="submitno" value="no">
</form>
</body>

<?php

	///////////////LOCALHOST TEST
	try {
	  // open connection to MongoDB server
	$mongo_connection = new MongoClient("mongodb://localhost:27017");
	$mongo_collection = $mongo_connection->selectCollection('test','rawVoteData');
	
	//{$or: [{'personacombo'=[firstPID,secondPID]}, {['personacombo'=[secondPID,firstPID]]} ]}

	//check if document with corresponding personaIDs already exists
	$mongo_query = array('$or'=> array(
		array('personacombo'=>array($firstpersonaID,$secondpersonaID)), 
		array('personacombo'=>array($secondpersonaID,$firstpersonaID))));
	$document = $mongo_collection->findOne($mongo_query);
	//print_r($mongo_query);
	
	//if the document object is not empty increase total votes
	if(!empty($document)) {
		$mongo_collection->update($mongo_query, array('$inc'=> array('totalvotes'=>1)));
		//echo 'Added 1 to total votes in pre-existing document <br/>';

		//if yes and pre-existing document
		if (isset($_POST['submityes'])){
			$mongo_collection->update($mongo_query, array('$inc'=> array('yesvotes'=>1)));
			//echo 'Added 1 to yesvotes in pre-existing document <br/>';
		}
	} 

	// insert a new document
	else {
		$object = array(
		"personacombo" => array($firstpersonaID,$secondpersonaID),
		"yesvotes" => 0,
		"totalvotes" => 1,
		);
		$mongo_collection->save($object);
		//echo 'New document created <br/>';

		//if yes and new document
		if (isset($_POST['submityes'])){
			$mongo_collection->update($mongo_query, array('$inc'=> array('yesvotes'=>1)));
			//echo 'Added 1 to yesvotes in new document <br/>';
		}

	}

	  // disconnect from server
      $mongo_connection->close();
    } catch (MongoConnectionException $e) {
      die('Error connecting to MongoDB server');
    } catch (MongoException $e) {
      die('Error: ' . $e->getMessage());
    }


?>

</html>