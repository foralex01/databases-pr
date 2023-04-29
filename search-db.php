<?php

function searchCourses($searchText)
{
    global $db;
	// define query
	$query = "SELECT * FROM Course NATURAL JOIN Section WHERE dept_abbr LIKE :searchText OR course_code LIKE :searchText OR course_name LIKE :searchText OR description LIKE :searchText";
    // prepare query
	$statement = $db->prepare($query);
    $statement->bindValue(':searchText', '%'.$searchText.'%');
	// execute
    $statement->execute();
	$data = $statement->fetchAll(); // fetchAll() gets all the rows, fetch() gets just the first row
	// close cursor
	$statement->closeCursor();
	// return result
	return $data;
}

function getAllCourses()
{
    global $db;
	// define query
	$query = "SELECT * FROM Course NATURAL JOIN Section";
	// prepare query
	$statement = $db->prepare($query);
	// execute
	$statement->execute();
	$data = $statement->fetchAll(); // fetchAll() gets all the rows, fetch() gets just the first row
	// close cursor
	$statement->closeCursor();
	// return result
	return $data;
}

?>