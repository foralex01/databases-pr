<?php

function getFname($computingid) {
    global $db;
    $query = "SELECT first_name FROM Student WHERE cid = '"$computingid"'";
	$statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}


function getLname() {
    global $db
    $query = "SELECT last_name FROM Student WHERE cid = :cid";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}
function updateProfile($first_name, $last_name, $major, $concentration) {
    $query = "update User set first_name = :fname, last_name = :lname, major = :new_major, concentration = :concentration";
	$statement = $db->prepare($query);
	// $statement->bindValue(':fname', $first_name);
    // $statement->bindValue(':lname', $last_name);
	// $statement->bindValue(':major', $major);
	// $statement->bindValue(':concentration', $concentration);
	$statement->execute();
    $results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
	
}
?>


