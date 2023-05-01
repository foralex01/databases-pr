<?php 

//$_SESSION["cid"]

require('connect-db.php');

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
  header("location: login.php"); // change from welcome.php to whatever we want our first page to be
  exit;
}
else {
  $cid = $_SESSION["cid"];
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
                    <li class="nav-item active"><a class="nav-link" href="planner.php">My Planner</a></li>
                    <li class="nav-item"><a class="nav-link" href="/databases-pr/requirements.php">Degree Requirements</a></li>
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
<h3>Degree Requirements Progress <h3>
</div>

</br>
</br>

 
<?




?>




<?php $current_user = findMajorByUser($_SESSION["cid"]); 


$major_requirements = displayRequirements($current_user['major_name']); 

$completed_requirements = coursesCompleteRequirements($current_user['major_name'],$_SESSION["cid"]);



// echo $x;

?>






<?php 

$x = 0;

foreach ($major_requirements as $req):

  $x = $x + $req['num_required'];




endforeach; 



$y = 0;


foreach ($completed_requirements as $req):

  $y = $y + $req['C'];



endforeach; 




$result = ($y / $x) * 100;

// echo round($result);

?>



<!-- <div class="w3-light-grey w3-xlarge">
  <div class="w3-container w3-green" style="width:25%"> 50% </div>
</div> -->

</br>
</br>
</br>


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
        <td class = "tables-success"><?php echo $req['requirement_name']; ?> </br></td>
        <td><?php echo $req['num_required']; ?></br></td>
     
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

<?php $completed_requirements = coursesCompleteRequirements($current_user['major_name'], $_SESSION["cid"]); ?>


<table class="w3-table w3-bordered w3-card-4 center" style="width:100%">


  <thead>
    <th> Remaining Requirements: </th>
    <tr style="background-color:#DCEDC8">
      <th scope="col">Requirement</th>
      <th scope="col">Number of Requirements </th>
      <th scope="col">Currently Being Fulfilled By: </th>
      <th scope="col">Possible Courses to Fulfill these Requirements: </th>
    </tr>
  </thead>


  <tbody>

  

  <!-- displaying remaining requirements -->
  <?php foreach ($major_requirements as $req):


    
    
    $x = 0;

    $h = classes($current_user['major_name'], $_SESSION["cid"], $req['requirement_name']); 

    $a = countDifference($current_user['major_name'], $_SESSION["cid"], $req['requirement_name']); 


    $m = "";
    $n = "";

    $d = "";
    $z = "";

    foreach ($h as $count):

      
      $m = $m .= $count['dept_abbr'];
      $n = $n .= $count['course_code'];

    

    endforeach;

    

    
    foreach ($a as $count):

      $x = $x + $count['C'];
      $d = $d .= $count['dept_abbr'];
      $z = $z .= $count['course_code'];

    endforeach;

    ?>
    
      <tr class="table-success">
        <td class = "tables-success"><?php echo $req['requirement_name']; ?></td>
        <td><?php echo $req['num_required'] - $x; ?></td>
        <td><?php echo $d;?> <?php echo " ";?> <?php echo $z; ?></td>
        
        <td><?php echo $m;?> <?php echo " ";?><?php echo $n; ?></td>
     
      </tr>
  
  <?php endforeach; ?>
   
    </tr>
  </tbody>
</table>



<!-- fulfilled by dept and course codes where course_fulfills_requirement.requirement = requirement ,, display codes-->

<!-- completed requirements allows me to see what has been yet been completed -->

<!-- use the C to filter the number that have been completed -->


</br>
</br>







<!-- function that shows the difference between the already completed requirements 
and the requirements that need to be met -->

<!-- return count where requiremernt_name == ___ -->



<br/>


<table class="w3-table w3-bordered w3-card-4 center" style="width:100%">


  <thead>
    <th> You have taken these classes: </th>
    <tr style="background-color:#DCEDC8">
      <th scope="col">Department Acronymn and Class Code</th>
      
    </tr>
  </thead>


  <tbody>


  <?php 

  $taken = takenCourses($_SESSION["cid"]);
  
  foreach ($taken as $s): ?>
    
      <tr class="table-success">
        <td class = "tables-success"><?php echo $s['dept_abbr']; ?> <?php echo " "; ?> <?php echo $s['course_code']; ?></br></td>
     
      </tr>
  
  <?php endforeach; ?>
   
    </tr>
  </tbody>
</table>






<?php



//first display all requirements
//return that requriement name 
// then use that requirement name to find the number





//find difference in requirements



// ?>







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
