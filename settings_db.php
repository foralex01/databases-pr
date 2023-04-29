<?php
function getFname($cid) {
    global $db;
    $query = "SELECT first_name FROM Student WHERE cid = :cid";
	$statement = $db->prepare($query);
    $statement->bindValue(':cid', $cid);
    $statement->execute();
    $results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function getLname($cid) {
    global $db;
    $query = "SELECT last_name FROM Student WHERE cid = :cid";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}

function updateProfile($first_name, $last_name, $major, $concentration) {
    $query = "UPDATE User SET first_name = :fname, last_name = :lname, major = :new_major, concentration = :concentration";
	$statement = $db->prepare($query);
	$statement->bindValue(':fname', $first_name);
    $statement->bindValue(':lname', $last_name);
	$statement->bindValue(':major', $major);
	$statement->bindValue(':concentration', $concentration);
	$statement->execute();
    $results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
	
}
?>


