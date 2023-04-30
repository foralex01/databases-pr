<!-- Logic for multiple conditions adapted from: https://stackoverflow.com/questions/13206530/search-filtering-with-php-mysql -->

<?php

function searchCourses($postVariables)
{
    global $db;
	// define query

    // piece together filters
    echo $searchText = $postVariables['searchText'];
    echo $semesterYear = $postVariables['semesterYearFilter'];
    echo $dept = $postVariables['deptFilter'];
    $semester;
    $year;

    $query = "SELECT * FROM Course NATURAL JOIN Section";
    $conditions = array();

    if (!empty($semesterYear) && $semesterYear != "Filter by Semester...") {
        // echo $semesterYear; // looks good
        [$semester, $year] = parseSemesterYear($semesterYear);

        $conditions[] = "semester = :semester";
        $conditions[] = "year = :year";
    }
    if (!empty($searchText))
    {
        $conditions[] = "(dept_abbr LIKE :searchText OR course_code LIKE :searchText OR course_name LIKE :searchText OR description LIKE :searchText)";
    }
    if (!empty($dept)) {
        $conditions[] = "dept_abbr = :dept";
    }

    // add conditions
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
        echo $query;
    }

    // prepare query
	$statement = $db->prepare($query);
    $statement->bindValue(':searchText', '%'.$searchText.'%');
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':dept', $dept);
	
    // execute
    $statement->execute();
	$data = $statement->fetchAll(); // fetchAll() gets all the rows, fetch() gets just the first row
	// close cursor
	$statement->closeCursor();
	// return result
	return $data;
}

function parseSemesterYear($semesterYear) 
{
    switch ($semesterYear) {
        case "Spring 2023":
            $semester = "Spring";
            $year = 2023;
            return [$semester, $year];
        case "Summer 2023":
            $semester = "Summer";
            $year = 2023;
            return [$semester, $year];
        case "Fall 2023":
            $semester = "Fall";
            $year = 2023;
            return [$semester, $year];
        case "Spring 2022":
            $semester = "Spring";
            $year = 2022;
            return [$semester, $year];
        case "Summer 2022":
            $semester = "Summer";
            $year = 2022;
            return [$semester, $year];
        case "Fall 2022":
            $semester = "Fall";
            $year = 2022;
            return [$semester, $year];
        case "Spring 2021":
            $semester = "Spring";
            $year = 2021;
            return [$semester, $year];
        case "Summer 2021":
            $semester = "Summer";
            $year = 2021;
            return [$semester, $year];
        case "Fall 2021":
            $semester = "Fall";
            $year = 2021;
            return [$semester, $year];
        case "Spring 2020":
            $semester = "Spring";
            $year = 2020;
            return [$semester, $year];
        case "Summer 2020":
            $semester = "Summer";
            $year = 2020;
            return [$semester, $year];
        case "Fall 2020":
            $semester = "Fall";
            $year = 2020;
            return [$semester, $year];
        case "Spring 2019":
            $semester = "Spring";
            $year = 2019;
            return [$semester, $year];
        case "Summer 2019":
            $semester = "Summer";
            $year = 2019;
            return [$semester, $year];
        case "Fall 2019":
            $semester = "Fall";
            $year = 2019;
            return [$semester, $year];
    }
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