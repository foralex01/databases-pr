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

$years = getYears($_SESSION["cid"]);
$semesters = getSems($_SESSION["cid"]);
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
            <label for="dropdowns"> Select Year and Semester </label>
            <div class="container" id="dropdowns">
                <select name="year" id="year" required>
                    <?php foreach ($years as $year): ?>
                        <option value=<?php echo $year['year']; ?>><?php echo $year['year']; ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="sem" id="sem" required>
                    <?php foreach ($semesters as $sem): ?>
                        <option value=<?php echo $sem['semester']; ?>><?php echo $sem['semester']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

</body>
</html>