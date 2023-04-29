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

function addSectionToPlanner($cid, $dept, $course, $semester, $year)
{
    global $db;

	$query = "INSERT INTO Student_Plans_Course VALUES (:cid, :course_code, :dept_abbr, :semester, :year)";
	$statement = $db->prepare($query);

	$statement->bindValue(':cid', $cid);
	$statement->bindValue(':course_code', $course);
	$statement->bindValue(':dept_abbr', $dept);
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':year', $year);

	$statement->execute();
	$statement->closeCursor();
}

function markSectionAsTaken($cid, $dept, $course, $semester, $year)
{
    global $db;

	$query = "INSERT INTO Student_Takes_Course VALUES (:cid, :course_code, :dept_abbr, :semester, :year, NULL)";
	$statement = $db->prepare($query);

	$statement->bindValue(':cid', $cid);
	$statement->bindValue(':course_code', $course);
	$statement->bindValue(':dept_abbr', $dept);
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':year', $year);

	$statement->execute();
	$statement->closeCursor();
}

?>