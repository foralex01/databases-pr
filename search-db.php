<!-- Logic for multiple conditions adapted from: https://stackoverflow.com/questions/13206530/search-filtering-with-php-mysql -->

<?php

function searchCourses($postVariables)
{
    global $db;
	// define query

    // piece together filters
    $searchText = $postVariables['searchText'];
    $semesterYear = $postVariables['semesterYearFilter'];
    $dept = $postVariables['deptFilter'];
    $semester;
    $year;

    $query = "SELECT * FROM Course NATURAL JOIN Section";
    $conditions = array();

    if (!empty($semesterYear) && $semesterYear != "Filter by Semester...") {
        [$semester, $year] = parseSemesterYear($semesterYear);

        $conditions[] = "Section.semester = :semester";
        $conditions[] = "Section.year = :year";
    }
    if (!empty($searchText))
    {
        $conditions[] = "(dept_abbr LIKE :searchText OR course_code LIKE :searchText OR course_name LIKE :searchText OR description LIKE :searchText)";
    }
    if (!empty($dept) && $dept != "Filter by Department...") {
        $conditions[] = "Section.dept_abbr = :dept";
    }

    // add conditions
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
        $query .= " ORDER BY Section.dept_abbr";
    }

    // prepare query
	$statement = $db->prepare($query);
    if (!empty($searchText)) {
        $statement->bindValue(':searchText', '%'.$searchText.'%');
    }
    if (!empty($semesterYear) && $semesterYear != "Filter by Semester...") {
        $statement->bindValue(':semester', $semester);
        $statement->bindValue(':year', $year);
    }
    if (!empty($dept) && $dept != "Filter by Department...") {
        $statement->bindValue(':dept', $dept);
    }
	
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

function getCoursesPlanned($cid)
{
    global $db;

    $query = "SELECT Student_Plans_Course.course_code, Student_Plans_Course.dept_abbr, Student_Plans_Course.semester, Student_Plans_Course.year FROM Student_Plans_Course NATURAL JOIN Course WHERE cid = :cid";

    $statement = $db->prepare($query);
    $statement->bindValue(':cid', $cid);
    $statement->execute();
    $data = $statement->fetchAll();
    $statement->closeCursor();
    return $data;
}
function getCoursesTaken($cid) {
    global $db;

    $query = "SELECT Student_Takes_Course.course_code, Student_Takes_Course.dept_abbr, Student_Takes_Course.semester, Student_Takes_Course.year FROM Student_Takes_Course NATURAL JOIN Course WHERE cid = :cid";

    $statement = $db->prepare($query);
    $statement->bindValue(':cid', $cid);
    $statement->execute();
    $data = $statement->fetchAll();
    $statement->closeCursor();
    return $data;
}

function getAllCourses()
{
    global $db;
	// define query
	$query = "SELECT * FROM Course NATURAL JOIN Section GROUP BY course_code, dept_abbr, semester, year";
    $query .= " ORDER BY Section.dept_abbr";
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

function isAlreadyPlanned($course_code, $dept_abbr, $semester, $year, $coursesPlanned) {

    foreach($coursesPlanned as $course) {
        if ($course["course_code"] == $course_code && $course["dept_abbr"] == $dept_abbr && $course["semester"] == $semester && $course["year"] == $year) {
            return true;
        }
    }
}

function isAlreadyTaken($course_code, $dept_abbr, $semester, $year, $coursesTaken) {

    foreach($coursesTaken as $course) {
        if ($course["course_code"] == $course_code && $course["dept_abbr"] == $dept_abbr && $course["semester"] == $semester && $course["year"] == $year) {
            return true;
        }
    }
}

function removeSectionFromPlanner($cid, $dept, $course, $semester, $year) {
    global $db;
	$query = "DELETE FROM Student_Plans_Course WHERE cid = :cid AND dept_abbr = :dept AND course_code = :course AND semester = :semester AND year = :year";
	$statement = $db->prepare($query);

	$statement->bindValue(':cid', $cid);
	$statement->bindValue(':dept', $dept);
    $statement->bindValue(':course', $course);
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':year', $year);

	$statement->execute();
	$statement->closeCursor();
}

function unmarkSectionAsTaken($cid, $dept, $course, $semester, $year) {
    global $db;
	$query = "DELETE FROM Student_Takes_Course WHERE cid = :cid AND dept_abbr = :dept AND course_code = :course AND semester = :semester AND year = :year";
	$statement = $db->prepare($query);

	$statement->bindValue(':cid', $cid);
	$statement->bindValue(':dept', $dept);
    $statement->bindValue(':course', $course);
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':year', $year);

	$statement->execute();
	$statement->closeCursor();
}

?>