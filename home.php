<?php
require("connect-db.php");

// Initialize the session
session_start();
 
// Check if the user is not logged in, if not then redirect him to login/register page

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php"); // change from welcome.php to whatever we want our first page to be
    exit;
}
else {
    echo "cid: " . $_SESSION["cid"];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>UVA Student Course Planner</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <meta charset="UTF-8">  
    <meta name="author" content="Alexandra Martin, Henry Todd, Matthew Lunsford, Rebecca Chung"> 
        
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
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
</body>
</html>