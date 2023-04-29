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
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>DB interfacing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>
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

</br>
</br>

<div style="text-align:center;">
<h3>Requirements<h3>
</div>

</br>
</br>


  
  


<?php $current_user = findMajorByUser("ht6xd"); 

$major_requirements = displayRequirements($current_user['major_name']); 

?>



<body>

<table class="w3-table w3-bordered w3-card-4 center" style="width:100%">


  <thead>
    <th> Major Requirements - <?php echo $current_user['major_name'];?> </th>
    <tr style="background-color:#DCEDC8">
      <th scope="col">Requirement</th>
      <th scope="col">Number of Requirements </th>
    </tr>
  </thead>


  <tbody>
  <?php foreach ($major_requirements as $req): ?>
    
      <tr class="table-success">
        <td class = "tables-success"><?php echo $req['requirement_name']; ?></td>
        <td><?php echo $req['num_required']; ?></td>
     
      </tr>
  
  <?php endforeach; ?>
   
    </tr>
  </tbody>
</table>

  </br>
  </br>
  </br>
  </br>
  </br>

<?php $completed_requirements = coursesCompleteRequirements($current_user['major_name'], "ht6xd"); ?>

<table class="w3-table w3-bordered w3-card-4 center" style="width:50%">


  <thead>
    <th> Completed Requirements: <?php echo $current_user['major_name'];?> </th>
    <tr style="background-color:#DCEDC8">
      <th scope="col">Requirement</th>
      <th scope="col">Number of Requirements </th>
    </tr>
  </thead>


  <tbody>
  <?php foreach ($completed_requirements as $c_req): ?>
    
      <tr class="table-success">
        <td class = "tables-success"><?php echo $c_req['requirement_name']; ?></td>
        <td><?php echo $c_req['C']; ?></td>
     
      </tr>
  
  <?php endforeach; ?>
   
    </tr>
  </tbody>
</table>



</br>
</br>



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
