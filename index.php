<?php
require("connect-db.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>UVA Student Course Planner</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <meta charset="UTF-8">  
    <meta name="author" content="Alexandra Martin, Henry Todd, Matthew Lunsford, Rebecca Chung"> 
        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	<!-- <div class="mobile-menu" id="mobile-menu"> 
		Menu <img src="http://www.shoredreams.net/wp-content/uploads/2014/02/show-menu-icon.png">
	</div> -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="navbar-brand">
                <a class="navbar-brand" href="#">UVA Student Course Planner</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"><a class="nav-link" href="#">My Planner</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Degree Requirements</a></li>
                    <li class="nav-item"><a class="nav-link" href="search.php">Search Courses</a></li>
                </ul>
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">My Profile</a></li>
                </ul>
            </div>
        </div>
	</nav>
</body>
</html>