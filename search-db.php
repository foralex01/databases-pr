<?php

function searchCourses($searchText)
{
    global $db;
    $query = "SELECT * FROM `Course` WHERE course_code LIKE CONCAT('%', :searchText, '%') OR dept_abbr LIKE CONCAT('%', :searchText, '%') OR course_name LIKE CONCAT('%', :searchText, '%') OR description LIKE CONCAT('%', :searchText, '%')";
    $statement = $db->prepare($query);

    $statement->bindValue(':query', $query);
    // $statement->execute(array(':query' => '%'.$query.'%'));
    $data = $statement->fetchAll();

    $rows = $statement->rowCount();
    if ($rows < 1) 
    {
        echo "No results found";
    }

    statement->closecursor();
    return $data;
}

function getAllCourses()
{
    global $db;
    $query = "SELECT * FROM `Course`";
    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetchAll();

    $rows = $statement->rowCount();
    if ($rows < 1) 
    {
        echo "No results found";
    }

    statement->closecursor();
    return $data;
}

?>