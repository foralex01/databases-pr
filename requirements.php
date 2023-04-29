<?php 


require('connect-db.php');

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
  header("location: login.php"); // change from welcome.php to whatever we want our first page to be
  exit;
}


require('requirements-function.php');








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

<?php include('header.html') ?> 

<div class="container">


<?php 
// if (!empty($_POST['name']))
//    echo greeting($_POST['name']) . "<br/>";
?>

<h1>Requirements</h1>

  
  
<hr/>
<h2>User's (ht6xd) major </h2>


<?php $current_user = findMajorByUser("ht6xd"); 

echo $current_user['major_name'];?> </br>

</br>
</br>

<h2>User's (ht6xd) major requirements and number of each requirement</h2>

<?php $major_requirements = displayRequirements($current_user['major_name']); ?>


<?php foreach ($major_requirements as $c): ?>
  
  <?php echo $c['requirement_name']; 
  echo "   "; 
  echo $c['num_required'];
  
  ?> </br>     

<?php endforeach; ?>



<?php $completed_requirements = coursesCompleteRequirements($current_user['major_name'], "ht6xd"); ?>

</br>
</br>

<h2>User's (ht6xd) completed requirements:</h2>

<?php foreach ($completed_requirements as $c_req): ?>
  
  <?php echo $c_req['requirement_name']; ?>
  <?php
  echo "   "; 
  echo $c_req['C'];?> 

<?php endforeach; ?>

<h3> Fulfilled by: </h3>

<?php foreach ($completed_requirements as $req): ?>

<?php echo $req['dept_abbr'];
  echo $req['course_code'];
  ?> </br>     
<?php endforeach; ?>

<?php $final = remainingRequirements($current_user['major_name']); ?>


<?php foreach ($final as $f): ?>

  
  <?php echo $f['requirement_name']; ?>
  <?php
  echo "   "; 
  echo $f['num_required'];?> 

<?php endforeach; ?>

<?php foreach ($completed_requirements as $c_req): ?>
  
  <?php echo $c_req['requirement_name']; ?>
  <?php
  echo "   "; 
  echo $c_req['C'];?> 

<?php endforeach; ?>


<br/>
<?php include('footer.html') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
  



<?php
// function greeting($name)
// {
//    return "Hi, " . $_POST['name'];
// }
?>
