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
    $statement->bindValue(':cid', $cid);
    $statement->execute();
    $results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function updateMajor($cid, $major_name, $type, $concentration) {
    global $db;
    $query = "UPDATE Student_In_Major SET major = :major_name, concentration = :concentration WHERE cid = :cid";
	$statement = $db->prepare($query);
	//$statement->bindValue(':fname', $first_name);
    //$statement->bindValue(':lname', $last_name);
    $statement->bindValue(':cid', $cid);
	$statement->bindValue(':major_name', $major_name);
	$statement->bindValue(':concentration', $concentration);
	$statement->execute();
    // $results = $statement->fetchAll();
	$statement->closeCursor();
	//return $results;
	
}

function getPrimaryMajor($cid) {
    global $db;
    $query = "SELECT major_name, concentration FROM Student_In_Major WHERE cid=:cid AND major_name IS NOT NULL AND type=\"primary\"";
    if($statement = $db->prepare($query)) {
        $statement->bindValue(":cid", $cid);
        if($statement->execute()) {
            $rows = $statement->fetch();
            unset($statement);
            return $rows;
        }
        else {
            echo "error fetching primary major";
            unset($statement);
        }
    }
}
 

function getSecondMajor($cid) {
    global $db;
    $query = "SELECT major_name, concentration FROM Student_In_Major WHERE cid=:cid AND type=\"secondary\"";
    if($statement = $db->prepare($query)) {
        $statement->bindValue(":cid", $cid);
        if($statement->execute()) {
            $rows = $statement->fetch();
            unset($statement);
            return $rows;
        }
        else {
            echo "error fetching secondary major";
            unset($statement);
        }
    }
}

function getMajor() {
    global $db;
    $query = "SELECT major_name FROM Major_Department";
    if($stmt = $db->prepare($query)) {
        if($stmt->execute()) {
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }
        else {
            unset($stmt);
            echo "error getting all majors";
        }
    }
}
function updatePrimaryMajor($cid, $new_major_name, $new_concentration) {
    global $db;
    $query = "UPDATE Student_In_Major SET major_name = :major_name, concentration = :concentration WHERE cid = :cid AND type = \"primary\"";
    $statement = $db->prepare($query);
    $statement->bindValue(':cid', $cid);
    $statement->bindValue(':major_name', $new_major_name);
    $statement->bindValue(':concentration', $new_concentration);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}

function insertPrimaryMajor($cid, $major_name, $concentration) {
    global $db;
    $query = "INSERT INTO Student_In_Major (cid, major_name, concentration, type) VALUES (:cid, :major_name, :concentration, \"primary\")";
    $statement = $db->prepare($query);
    $statement->bindValue(':cid', $cid);
    $statement->bindValue(':major_name', $major_name);
    $statement->bindValue(':concentration', $concentration);
    $result = $statement->execute();
    $statement->closeCursor();
    //return $result;
}

function updateSecondMajor($cid, $major_name, $concentration) {
    global $db;
    $query = "UPDATE Student_In_Major SET major_name = :major_name, concentration = :concentration WHERE cid = :cid AND type = \"secondary\"";
	$statement = $db->prepare($query);
	$statement->bindValue(':cid', $cid);
	$statement->bindValue(':major_name', $major_name);
	$statement->bindValue(':concentration', $concentration);
	$statement->execute();
	$statement->closeCursor();
}

function insertSecondMajor($cid, $major_name, $concentration) {
    global $db;
    $query = "INSERT INTO Student_In_Major (cid, major_name, type, concentration) VALUES (:cid, :major_name, \"secondary\", :concentration)";
	$statement = $db->prepare($query);
	$statement->bindValue(':cid', $cid);
	$statement->bindValue(':major_name', $major_name);
	$statement->bindValue(':concentration', $concentration);
	$statement->execute();
	$statement->closeCursor();
    //return result;

}





