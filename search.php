<!-- Table design: https://bootsnipp.com/snippets/rz -->
<!-- Search bar design: https://bootsnipp.com/snippets/35V6b -->

<?php
require('connect-db.php');
require('search-db.php');

session_start();

$searchResults;
$coursesPlanned;
$coursesTaken;

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $cid = $_SESSION["cid"];
    $searchResults = getAllCourses();
    $coursesPlanned = getCoursesPlanned($_SESSION['cid']);
    $coursesTaken = getCoursesTaken($_SESSION['cid']);
}
else {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['searchBtn']))
    {
        $postVariables = $_POST;
        $coursesPlanned = getCoursesPlanned($_SESSION['cid']);
        $coursesTaken = getCoursesTaken($_SESSION['cid']);
        $searchResults = searchCourses($postVariables, $cid);
    }
    if (isset($_POST['PlannerButton']))
    {
        $dept = $_POST['dept_plan'];
        $course = $_POST['code_plan'];
        $semester = $_POST['semester_plan'];
        $year = $_POST['year_plan'];
        addSectionToPlanner($cid, $dept, $course, $semester, $year);

        $coursesPlanned = getCoursesPlanned($_SESSION['cid']);
        $coursesTaken = getCoursesTaken($_SESSION['cid']);
        //$searchResults = getAllCourses();
    }
    if (isset($_POST['TakeButton']))
    {
        $cid = $_SESSION["cid"];
        $dept = $_POST['dept_take'];
        $course = $_POST['code_take'];
        $semester = $_POST['semester_take'];
        $year = $_POST['year_take'];
        markSectionAsTaken($cid, $dept, $course, $semester, $year);

        $coursesPlanned = getCoursesPlanned($_SESSION['cid']);
        $coursesTaken = getCoursesTaken($_SESSION['cid']);
        //$searchResults = getAllCourses();
    }
    if (isset($_POST['RemovePlanner'])) {
        $cid = $_SESSION["cid"];
        $dept = $_POST['dept_plan'];
        $course = $_POST['code_plan'];
        $semester = $_POST['semester_plan'];
        $year = $_POST['year_plan'];
        removeSectionFromPlanner($cid, $dept, $course, $semester, $year);
        
        $coursesPlanned = getCoursesPlanned($_SESSION['cid']);
        $coursesTaken = getCoursesTaken($_SESSION['cid']);
        //$searchResults = getAllCourses();
    }
    if (isset($_POST['RemoveTaken'])) {
        $cid = $_SESSION["cid"];
        $dept = $_POST['dept_take'];
        $course = $_POST['code_take'];
        $semester = $_POST['semester_take'];
        $year = $_POST['year_take'];
        unmarkSectionAsTaken($cid, $dept, $course, $semester, $year);

        $coursesPlanned = getCoursesPlanned($_SESSION['cid']);
        $coursesTaken = getCoursesTaken($_SESSION['cid']);
        //$searchResults = getAllCourses();
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <?php include('navbar.php');?>
    <div class="container">
        <br/>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form class="card card-sm" action="search.php" method="post">
                    <div class="card-body row no-gutters align-items-center">
                        <div class="col-lg-3">
                            <input class="form-control form-control-borderless" type="text" name="searchText" placeholder="Search by keyword" />
                        </div>
                        <!-- ability to filter semester/year -->
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
                        <!-- ability to filter department -->
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
                            <input class="btn  btn-success" type="submit" name="searchBtn" value="Search" style="width:10em;"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </br>

    <div class="container">
                <table class="table table-list-search">
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
                                    <?php if(isAlreadyPlanned($row["course_code"], $row["dept_abbr"], $row["semester"], $row["year"], $coursesPlanned)): ?>
                                            <input type="submit" name="RemovePlanner" value="Remove From Planner" class="btn btn-danger" style="width:11.5em;height:2.5em;" />
                                        <?php else: ?>
                                            <input type="submit" name="PlannerButton" value="Add to Planner" class="btn btn-dark" style="width:11.5em;height:2.5em;"/>
                                        <?php endif; ?>
                                    <input type="hidden" name="dept_plan" value ="<?php echo $row['dept_abbr']; ?>" />
                                    <input type="hidden" name="code_plan" value ="<?php echo $row['course_code']; ?>" />
                                    <input type="hidden" name="semester_plan" value ="<?php echo $row['semester']; ?>" />
                                    <input type="hidden" name="year_plan" value ="<?php echo $row['year']; ?>" />
                                </form>
                            </td>
                            <td>
                                <form action="search.php" method="post">
                                    <?php if(isAlreadyTaken($row["course_code"], $row["dept_abbr"], $row["semester"], $row["year"], $coursesTaken)): ?>
                                            <input type="submit" name="RemoveTaken" value="Unmark as Taken" class="btn btn-danger" style="width:10em;height:2.5em;"/>
                                    <?php else: ?>
                                            <input type="submit" name="TakeButton" value="Mark as Taken" class="btn btn-dark" style="width:10em;height:2.5em;"/>
                                    <?php endif; ?>
                                    <input type="hidden" name="dept_take" value ="<?php echo $row['dept_abbr']; ?>" />
                                    <input type="hidden" name="code_take" value ="<?php echo $row['course_code']; ?>" />
                                    <input type="hidden" name="semester_take" value ="<?php echo $row['semester']; ?>" />
                                    <input type="hidden" name="year_take" value ="<?php echo $row['year']; ?>" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
    </div>
<body>
</html>