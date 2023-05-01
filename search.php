<!-- Table design: https://bootsnipp.com/snippets/rz -->
<!-- Search bar design: https://bootsnipp.com/snippets/35V6b -->

<?php
require('connect-db.php');
require('search-db.php');

session_start();

$searchResults = getAllCourses();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['searchBtn']) && ($_POST['searchBtn'] == "Search"))
    {
        $postVariables = $_POST;
        $searchResults = searchCourses($postVariables);
    }
    if (!empty($_POST['PlannerButton']) && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        echo $cid = $_SESSION["cid"];
        echo $dept = $_POST['dept_to_plan'];
        echo $course = $_POST['code_to_plan'];
        echo $semester = $_POST['semester_to_plan'];
        echo $year = $_POST['year_to_plan'];
        addSectionToPlanner($cid, $dept, $course, $semester, $year);
    }
    if (!empty($_POST['TakeButton']) && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        echo $cid = $_SESSION["cid"];
        echo $dept = $_POST['dept_taken'];
        echo $course = $_POST['code_taken'];
        echo $semester = $_POST['semester_taken'];
        echo $year = $_POST['year_taken'];
        markSectionAsTaken($cid, $dept, $course, $semester, $year);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="author" content="Alexandra Martin, Henry Todd, Matthew Lunsford, Rebecca Chung"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <?php include('home.php');?>
    <div class="container">
        <br/>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form class="card card-sm" action="search.php" method="post">
                    <div class="card-body row no-gutters align-items-center">
                        <div class="col-lg-3">
                            <input class="form-control form-control-borderless" type="text" name="searchText" placeholder="Search by keyword" />
                        </div>
                        <!-- Add ability to filter semester/year -->
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <select class="form-control search-slt" name="semesterYearFilter">
                                <option>Filter by Semester...</option>
                                <option>Fall 2023</option>
                                <option>Summer 2023</option>
                                <option>Spring 2023</option>
                                <option>Fall 2022</option>
                                <option>Summer 2022</option>
                                <option>Spring 2022</option>
                                <option>Fall 2021</option>
                                <option>Summer 2021</option>
                                <option>Spring 2021</option>
                                <option>Fall 2020</option>
                                <option>Summer 2020</option>
                                <option>Spring 2020</option>
                                <option>Fall 2019</option>
                                <option>Summer 2019</option>
                                <option>Spring 2019</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <select class="form-control search-slt" name="deptFilter">
                                <option>Filter by Department...</option>
                                <option>GOV</option>
                                <option>STAT</option>
                                <option>MSE</option>
                                <option>MATH</option>
                                <option>APMA</option>
                                <option>MSE</option>
                                <option>FREN</option>
                                <option>ART</option>
                                <option>ECE</option>
                                <option>BME</option>
                                <option>SYSE</option>
                                <option>MUSI</option>
                                <option>GERM</option>
                                <option>CLAS</option>
                                <option>SUST</option>
                                <option>PSYC</option>
                                <option>EDUC</option>
                                <option>ENGR</option>
                                <option>ARCH</option>
                                <option>PLRL</option>
                                <option>NURS</option>
                                <option>SPAN</option>
                                <option>PHYS</option>
                                <option>CME</option>
                                <option>CVEE</option>
                                <option>BIOL</option>
                                <option>ARCY</option>
                                <option>JWST</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <input class="btn btn-lg btn-success" type="submit" name="searchBtn" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </br>

    <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th>Dept</th>
                            <th>Course</th>
                            <th>Name</th>
                            <th>Semester</th>
                            <th>Year</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <?php foreach($searchResults as $row): ?>
                        <tr>
                            <td><?php echo $row['dept_abbr']; ?></td>
                            <td><?php echo $row['course_code']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['year']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <form action="search.php" method="post">
                                    <input type="submit" name="PlannerButton" value="Add To Planner" class="btn btn-dark" />
                                    <input type="hidden" name="dept_to_plan" value ="<?php echo $row['dept_abbr']; ?>" />
                                    <input type="hidden" name="code_to_plan" value ="<?php echo $row['course_code']; ?>" />
                                    <input type="hidden" name="semester_to_plan" value ="<?php echo $row['semester']; ?>" />
                                    <input type="hidden" name="year_to_plan" value ="<?php echo $row['year']; ?>" />
                                </form>
                            </td>
                            <td>
                                <form action="search.php" method="post">
                                    <input type="submit" name="TakeButton" value="Mark As Taken" class="btn btn-dark" />
                                    <input type="hidden" name="dept_taken" value ="<?php echo $row['dept_abbr']; ?>" />
                                    <input type="hidden" name="code_taken" value ="<?php echo $row['course_code']; ?>" />
                                    <input type="hidden" name="semester_taken" value ="<?php echo $row['semester']; ?>" />
                                    <input type="hidden" name="year_taken" value ="<?php echo $row['year']; ?>" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
    </div>
<body>
</html>