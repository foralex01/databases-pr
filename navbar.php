<?php 
$file = substr($_SERVER["SCRIPT_NAME"], 9); 

?>

<head>
    <style>
        .navbar-custom .navbar-brand {
            background-color: "orange";
        }
    </style>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-brand">
            <a class="navbar-brand" href="planner.php">UVA Student Course Planner</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($file=="planner.php"){echo "active";}?>"><a class="nav-link" href="planner.php">My Planner</a></li>
                <li class="nav-item <?php if($file=="requirements.php"){echo "active";}  ?>"><a class="nav-link" href="requirements.php">Degree Requirements</a></li>
                <li class="nav-item <?php if($file=="search.php"){echo "active";}  ?>"><a class="nav-link" href="search.php">Search Courses</a></li>
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item <?php if($file=="settings.php"){echo "active";}  ?>"><a class="nav-link" href="settings.php">Settings</a></li>
            </ul>
        </div>
    </div>
</nav>