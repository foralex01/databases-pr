<?php
require_once("connect-db.php");
require("planner-db.php");

// Initialize the session
session_start();
 
// Check if the user is not logged in, if not then redirect him to login/register page

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php"); // change from welcome.php to whatever we want our first page to be
    exit;
}
else {
    $cid = $_SESSION["cid"];
}

$years = getYears($cid);
$semesters = getSems($cid);

// $courses = getCourses($cid);
$planned_courses = getPlannedCourses($cid);
$taken_courses = getTakenCourses($cid);

$curr_year = "all";
$curr_sem = "all";

$na = true;

//Checking seasons code referenced from: https://stackoverflow.com/questions/40893960/php-how-to-check-the-season-of-the-year-and-set-a-class-accordingly
// get today's date
$today = new DateTime();

// get the semester dates
$fall_start = new DateTime('August 18');
$fall_end = new DateTime('December 16');
$spring_start = new DateTime('March 20');
$spring_end = new DateTime('May 12');
$summer_start = new DateTime('May 22');
$summer_end = new DateTime('August 11');

$curr_semester = "";

//set the semester
if ($fall_start <= $today && $today <= $fall_end) {
    $curr_semester = "Fall";
}
elseif ($spring_start <= $today && $today <= $spring_end) {
    $curr_semester = "Spring";
}
else {
    $curr_semester = "Summer";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["year"])) {
        if($_POST["year"] == "all") {
            $na = true;
            $curr_sem = "na";
            // $courses = getCourses($cid);
            $planned_courses = getPlannedCourses($cid);
            $taken_courses = getTakenCourses($cid);
        }
        else {
            $na = false;
            $curr_sem = $_POST["sem"];
            $curr_year = $_POST["year"];
            // $courses = getCoursesSemYear($cid, $curr_sem, $curr_year);
            $planned_courses = getPlannedCoursesSemYear($cid, $curr_sem, $curr_year);
            $taken_courses = getTakenCoursesSemYear($cid, $curr_sem, $curr_year);
        }
        $curr_year = $_POST["year"];
    }

    if(isset($_POST["TakenDelete"])) {
        deleteTaken($cid, $_POST["course_code"], $_POST["dept_abbr"]);
        if($_POST["year"] == "all") {
            $taken_courses = getTakenCourses($cid);
        }
        else {
            $taken_courses = getTakenCoursesSemYear($cid, $_POST['sem'], $_POST['year']);
        }
    }

    elseif(isset($_POST["PlannerDelete"])) {
        deletePlanner($cid, $_POST["course_code"], $_POST["dept_abbr"]);
        if($_POST['year'] == "all") {
            $planned_courses = getPlannedCourses($cid);
        }
        else {
            $planned_courses = getPlannedCoursesSemYear($cid, $_POST['sem'], $_POST['year']);
        }
    }
}
// var_dump($curr_sem);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Course Planner and Past Schedule Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

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
	<!-- <div class="mobile-menu" id="mobile-menu"> 
		Menu <img src="http://www.shoredreams.net/wp-content/uploads/2014/02/show-menu-icon.png">
	</div> -->
	<?php include("navbar.php"); ?>

    <!--TODO: Add planner section

    Dropdown to choose year and semester (or all)
        -allow into future (check planned courses)
        -allow into past (check Student_Takes_Course)


    Display list of courses for selected year/semester
        -if all, seperate by year/semester blocks
        -else list all courses
    -->
    <div class="container">
        <br/>
        <h1> Planner </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row" id="dropdowns">
                <div class="col-sm-2">
                    <label for="year">Year:</label>
                    <select class="form-select" name="year" id="year" required onchange=this.form.submit();>
                        <option value="all"> All </option>
                        <?php foreach ($years as $year): ?>
                            <option value=<?php echo $year['year']; ?> <?php if($curr_year == $year['year']) { ?> selected=true <?php }; ?>><?php echo $year['year']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="sem">Semester: </label>
                    <select class="form-select" name="sem" id="sem" required onchange=this.form.submit();>
                        <?php if(!$na): ?>
                        <?php foreach ($semesters as $sem): ?>
                            <option value=<?php echo $sem['semester']; ?> <?php if($curr_sem == $sem['semester']) { ?> selected=true <?php }; ?> ><?php echo $sem['semester']; ?></option>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <option value = "Fall"> N/A </option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <br/>
    <div class="container">
        <!-- Display "Planner" or "Schedule" based on if year is current year or before -->
        <?php if($curr_year == "all"): ?>
            <h2>All Courses</h2>
        <?php elseif($curr_year < date("Y")): //definitely older?>
            <h2>Previous Courses</h2>
        <?php else:  //need to check if current semester or in future?>
            <?php if($curr_semester == $curr_sem): ?>
                <h2> Current Semester </h2>
            <?php else: ?>
                <h2>Planned Courses</h2>
            <?php endif; ?>
        <?php endif; ?>
        <!-- Display list of planned/previously taken courses based on selected year/sem -->
        <!-- If "all" courses, print ordered by year -->
        <h3> Enrolled </h3>
        <?php if (count($taken_courses) > 0): //check if taken classes for this semester ?>
        <div class="col-md-9"> 
            <table class="table table-list-search">
                <thead>
                    <tr>
                        <th>Dept</th>
                        <th>Course</th>
                        <th>Name</th>
                        <th>Semester</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <?php foreach($taken_courses as $row): ?>
                    <tr>
                        <td><?php echo $row['dept_abbr']; ?></td>
                        <td><?php echo $row['course_code']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="submit" name="TakenDelete" value="remove" class="btn btn-danger" style="width:6.5em; height: 2.2em; margin:auto" />
                                <input type="hidden" name="dept_abbr" value ="<?php echo $row['dept_abbr']; ?>" />
                                <input type="hidden" name="course_code" value ="<?php echo $row['course_code']; ?>" />
                                <input type="hidden" name="year" value = <?php echo $curr_year; ?> />
                                <input type="hidden" name="sem" value = <?php echo $curr_sem; ?> />
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php 
            else:
                echo "<p> No courses enrolled this semester";
            endif; 
        ?>
        <h3> Planned </h3>
        <?php if (count($planned_courses) > 0): ?>
            <div class="col-md-9"> 
                <table class="table table-list-search">
                    <thead>
                        <tr>
                            <th>Dept</th>
                            <th>Course</th>
                            <th>Name</th>
                            <th>Semester</th>
                            <th>Year</th>
                        </tr>
                    </thead>
                    <?php foreach($planned_courses as $row): ?>
                        <tr>
                            <td><?php echo $row['dept_abbr']; ?></td>
                            <td><?php echo $row['course_code']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['year']; ?></td>
                            <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="submit" name="PlannerDelete" value="remove" class=" btn-danger" style="width:6.5em; height:2.3em;" />
                                <input type="hidden" name="dept_abbr" value ="<?php echo $row['dept_abbr']; ?>" />
                                <input type="hidden" name="course_code" value ="<?php echo $row['course_code']; ?>" />
                                <input type="hidden" name="year" value = <?php echo $curr_year; ?> />
                                <input type="hidden" name="sem" value = <?php echo $curr_sem; ?> />
                            </form>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php 
            else:
                echo "<p> No courses planned for this semester";
            endif; 
        ?>
    </div>
</body>
</html>