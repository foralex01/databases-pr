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

$courses = getCourses($cid);

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
    if($_POST["year"] == "all") {
        $na = true;
        $curr_sem = "na";
        $courses = getCourses($cid);
    }
    else {
        $na = false;
        $curr_sem = $_POST["sem"];
        $curr_year = $_POST["year"];
        $courses = getCoursesSemYear($cid, $curr_sem, $curr_year);
    }
    $curr_year = $_POST["year"];
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
        <h1> Planner </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="container" id="dropdowns">
                <label for="year">Year:</label>
                <select name="year" id="year" required onchange=this.form.submit();>
                    <option value="all"> All </option>
                    <?php foreach ($years as $year): ?>
                        <option value=<?php echo $year['year']; ?> <?php if($curr_year == $year['year']) { ?> selected=true <?php }; ?>><?php echo $year['year']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="sem">Semester: </label>
                <select name="sem" id="sem" required onchange=this.form.submit();>
                    <?php if(!$na): ?>
                    <?php foreach ($semesters as $sem): ?>
                        <option value=<?php echo $sem['semester']; ?> <?php if($curr_sem == $sem['semester']) { ?> selected=true <?php }; ?> ><?php echo $sem['semester']; ?></option>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <option value = "Fall"> N/A </option>
                    <?php endif; ?>
                </select>
            </div>
        </form>
    </div>
    <div class="container">
        <!-- Display "Planner" or "Schedule" based on if year is current year or before -->
        <?php if($curr_year == "all"): ?>
            <h2>All Courses</h2>
        <?php elseif($curr_year < date("Y")): //definitely older?>
            <h2>Previous Courses</h2>
        <?php else:  //need to check if current semester or in future?>
            <?php if($curr_semester == $curr_sem): ?>
                <h2> Current Schedule </h2>
            <?php else: ?>
                <h2>Planned Courses</h2>
            <?php endif; ?>
        <?php endif; ?>
        <!-- Display list of planned/previously taken courses based on selected year/sem -->
        <!-- If "all" courses, print ordered by year -->
        <div class="container"> 
            <table>
                <thead>
                    <tr>
                        <th>Dept</th>
                        <th>Course</th>
                        <th>Name</th>
                        <th>Semester</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <?php foreach($courses as $row): ?>
                    <tr>
                        <td><?php echo $row['dept_abbr']; ?></td>
                        <td><?php echo $row['course_code']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>