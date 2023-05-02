<?php

//TODO: add functions for interacting with the DB
function getYears($cid) {
    global $db;
    $query = "SELECT year FROM\n"

    . "(SELECT `year` FROM `Student_Takes_Course`\n"

    . "UNION\n"

    . "SELECT `year` FROM `Student_Plans_Course`) as T\n"

    . "WHERE year IS NOT NULL\n"

    . "ORDER BY year DESC;";
    // "(SELECT year FROM Student_Takes_Course WHERE year IS NOT NULL AND cid=:cid) UNION (SELECT year FROM Student_Plans_Course WHERE year IS NOT NULL AND cid=:cid)";
    if($stmt = $db->prepare($query)) {
        $stmt->bindValue(":cid", $cid);
        if($stmt->execute()) {
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }
        else {
            echo "error fetching years";
            unset($stmt);
        }
    }
}

function getSems($cid) {
    global $db;
    $query = "(SELECT semester FROM Student_Takes_Course WHERE semester IS NOT NULL AND cid=:cid) UNION (SELECT semester FROM Student_Plans_Course WHERE semester IS NOT NULL AND cid=:cid)";
    if($stmt = $db->prepare($query)) {
        $stmt->bindValue(":cid", $cid);
        if($stmt->execute()) {
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }
        else {
            echo "error fetching semesters";
            unset($stmt);
        }
    }
}

//get all planned courses for the current student
function getCourses($cid) {
    global $db;
    $query = "(SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Plans_Course NATURAL JOIN Course WHERE cid = :cid UNION
    SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Takes_Course NATURAL JOIN Course WHERE cid = :cid)
    ORDER BY year DESC, semester, dept_abbr, course_code";
    $stmt = $db->prepare($query);

    //Set cid
    $stmt->bindValue(":cid", $cid);

    //execute
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    //cleanup and return rows
    unset($stmt);
    return $rows;
}

//like above, but only planned courses
function getPlannedCourses($cid) {
    global $db;
    $query = "SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Plans_Course NATURAL JOIN Course WHERE cid = :cid ORDER BY year DESC, semester, dept_abbr, course_code";
    $stmt = $db->prepare($query);

    //Set cid
    $stmt->bindValue(":cid", $cid);

    //execute
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    //cleanup and return rows
    unset($stmt);
    return $rows;
}

function getTakenCourses($cid) {
    global $db;
    $query = "SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Takes_Course NATURAL JOIN Course WHERE cid = :cid ORDER BY year DESC, semester, dept_abbr, course_code";
    $stmt = $db->prepare($query);

    //Set cid
    $stmt->bindValue(":cid", $cid);

    //execute
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    //cleanup and return rows
    unset($stmt);
    return $rows;
}

//get all courses for a particular semester and year
function getCoursesSemYear($cid, $sem, $year) {
    global $db;
    $query = "WITH T AS ";
    $query .= "(SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Plans_Course NATURAL JOIN Course WHERE cid=:cid";
    $query .= " UNION";
    $query .= " SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Takes_Course NATURAL JOIN Course WHERE cid=:cid)";
    $query .= " SELECT * FROM T";
    $query .= " WHERE semester = :sem AND year=:year";
    $query .= " ORDER BY dept_abbr, course_code";
    $stmt = $db->prepare($query);

    //Set cid
    $stmt->bindValue(":cid", $cid);
    $stmt->bindValue(":sem", $sem);
    $stmt->bindValue(":year", $year);

    //execute
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    //cleanup and return rows
    unset($stmt);
    return $rows;
}

function getPlannedCoursesSemYear($cid, $sem, $year) {
    global $db;
    $query = "SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Plans_Course NATURAL JOIN Course WHERE cid=:cid";
    $query .= " AND semester = :sem AND year=:year";
    $query .= " ORDER BY dept_abbr, course_code";
    $stmt = $db->prepare($query);

    //Set cid
    $stmt->bindValue(":cid", $cid);
    $stmt->bindValue(":sem", $sem);
    $stmt->bindValue(":year", $year);

    //execute
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    //cleanup and return rows
    unset($stmt);
    return $rows;
}

function getTakenCoursesSemYear($cid, $sem, $year) {
    global $db;
    $query = "SELECT dept_abbr, course_name, course_code, year, semester FROM Student_Takes_Course NATURAL JOIN Course WHERE cid=:cid";
    $query .= " AND semester = :sem AND year=:year";
    $query .= " ORDER BY dept_abbr, course_code";
    $stmt = $db->prepare($query);

    //Set cid
    $stmt->bindValue(":cid", $cid);
    $stmt->bindValue(":sem", $sem);
    $stmt->bindValue(":year", $year);

    //execute
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    //cleanup and return rows
    unset($stmt);
    return $rows;
}

function deletePlanner($cid, $course_code, $dept_abbr) {
    global $db;
    $query = "DELETE FROM Student_Plans_Course WHERE cid = :cid AND dept_abbr = :dept AND course_code = :course";
    $stmt = $db->prepare($query);

	$stmt->bindValue(':cid', $cid);
	$stmt->bindValue(':dept', $dept_abbr);
    $stmt->bindValue(':course', $course_code);

    $stmt->execute();
    unset($stmt);
}

function deleteTaken($cid, $course_code, $dept_abbr) {
    global $db;
    $query = "DELETE FROM Student_Takes_Course WHERE cid = :cid AND dept_abbr = :dept AND course_code = :course";
    $stmt = $db->prepare($query);

	$stmt->bindValue(':cid', $cid);
	$stmt->bindValue(':dept', $dept_abbr);
    $stmt->bindValue(':course', $course_code);

    $stmt->execute();
    unset($stmt);
}

?>

