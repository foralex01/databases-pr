<?php

// CREATE TABLE friends (
//    name varchar(30) NOT NULL,
//    major varchar(10) NOT NULL,
//    year int NOT NULL,
//    PRIMARY KEY (name) );

// Prepared statement (or parameterized statement) happens in 2 phases:
//   1. prepare() sends a template to the server, the server analyzes the syntax
//                and initialize the internal structure.
//   2. bind value (if applicable) and execute
//      bindValue() fills in the template (~fill in the blanks.
//                For example, bindValue(':name', $name);
//                the server will locate the missing part signified by a colon
//                (in this example, :name) in the template
//                and replaces it with the actual value from $name.
//                Thus, be sure to match the name; a mismatch is ignored.
//      execute() actually executes the SQL statement


function getAllDepartments()
{
	global $db;
	$query = "SELECT * FROM Department";
	$statement = $db->prepare($query);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;
}

function displayRequirements($major)
{

	global $db;
	$query = "SELECT * FROM Requirement WHERE major_name = '".$major."'";
	$statement = $db->prepare($query);
	$statement->execute();
	
	
	$results = $statement->fetchAll();
	
	
	$statement->closecursor();
	
	return $results;

}



// function that from the courses already taken, displays what is left
function coursesCompleteRequirements($major, $cid)
{

	global $db;

	// courses = find where dept, abbr FROM Student_Takes_Course (WHERE cid = what is passed in and 
	// major = what is passed in)
	// INTERSECTS with dept, abbr 
	// intersects with dept, abbr FROM Course_Fulfills Requirement WHERE department = major

	// ^ find the courses that complete the major requirements
	
	// next find the count of count of each requriement that is fulfilled 

	// how many of each requirement for the major is fulfilled?

	//SELECT count(courses) FROM Course_fulfills_requirements
	// GROUP BY requirment name

	//^ this gives me the number of each requirement I have completed

	//^ once I find this, I can compare this number to the 
	// number of each requirement that the make requires

	// and then show the remaining credits they need of each one 


	//FROM Student_Takes_Couse
	//WHERE cid = "adm8mwh" AND major = "Biomedical Engineering" AND Student_Takes_Course.dept_abbr 
	//IN (SELECT Course_Fulfills_Requirement.debt_abbr FROM COURSE_Fulfills_Requirement
	//WHERE Course_Fulfills_Requirement.debt_abbr = "BME")";

	
	$query = "SELECT cid, major_name, Course_Fulfills_Requirement.dept_abbr, Course_Fulfills_Requirement.course_code, requirement_name, COUNT(Course_Fulfills_Requirement.course_code) AS C FROM Course_Fulfills_Requirement, Student_Takes_Course WHERE
	cid = :cid AND Course_Fulfills_Requirement.course_code = Student_Takes_Course.course_code AND
	Course_Fulfills_Requirement.dept_abbr = Student_Takes_Course.dept_abbr
	GROUP BY requirement_name HAVING major_name = :major";

	//display the number of each requirement that is required for the major 

	//compare the requirements that have been fulfilled to the requirements that haven't been fulfilled

	//GROUP BY requirement

	// COUNT(course_codes)

	// ^ this will find the number of requirements filled for each requirement
	// ^ 
	
	

	
	

	$statement = $db->prepare($query);
	$statement->bindValue(':major', $major);
	$statement->bindValue(':cid', $cid);
	$statement->execute();

	//fetchAll() returns an array for all of the rows in the result set
	$results = $statement->fetchAll();

	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();

	return $results;


}

// function where you subtract (by requirement) the requirements taken from the requirement needed



function findMajorByUser($computingid)
{

	global $db;
	
	$query = "SELECT major_name FROM Student_In_Major WHERE cid = :computingid";
	$statement = $db->prepare($query);
	$statement->bindValue(':computingid', $computingid);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	// fetch() return a row
	$results = $statement->fetch();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;

	

}


function courses()
{

    global $db;

    //computing id is as passed in and courses_have_been_taken by the computing ID
	
	$query = "SELECT * FROM Course_Fulfills_Requirement";
    
    //.course_code, Course_Fulfills_Requirement.dept_abbr FROM
    //Course_Fulfills_Requirement, Student_Takes_Course WHERE cid = :cid";
    
    //AND requirement_name = :requirement
    //AND major = :major AND Student_Takes_Course.dept_abbr = Course_Fulfills_Requirement.dept_abbr AND
    //Student_Takes_Course.course_code = Course_Fulfills_Requirement.dept_abbr";

	$statement = $db->prepare($query);
	//$statement->bindValue(':requirement', $requirement);
    //$statement->bindValue(':major', $major);
    // $statement->bindValue(':cid', $cid);
	$statement->execute();
	
	// fetchAll() returns an array for all of the rows in the result set
	// fetch() return a row
	$results = $statement->fetchAll();
	
	// closes the cursor and frees the connection to the server so other SQL statements may be issued
	$statement->closecursor();
	
	return $results;




}





?>