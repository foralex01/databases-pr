<?php

//TODO: add functions for interacting with the DB

//get all planned courses for the current student
function getCourses($cid) {
    global $db
    $query = "SELECT * FROM Student_Plans_Course WHERE cid = :cid";
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
    global $db
    $query = "SELECT * FROM Student_Plans_Course WHERE cid = :cid AND semester=:sem AND year=:year";
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

?>

