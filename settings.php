<?php
require_once "connect-db.php";
require("settings_db.php");

session_start();

$profileFname;
$profileLname;
//$user_major;

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    $cid = $_SESSION["cid"];
    $profileFname = getFname($cid)['first_name'];
   // echo $profileFname;
    $profileLname = getLname($cid)['last_name'];

    
   // echo $profileLname;
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>

<body>
<?php include('home.php'); ?>
  <h1>Your Profile</h1>
<div class="profile-input-field">
        <h3>Keep your profile up-to-date!</h3>
        <form method="post" action="#" >
          <div class="form-group">
            <label>First Name</label>
    
            <input type="text" class="form-control" name="fname" style="width:20em;" placeholder="<?php echo $profileFname; ?>" value="<?php echo $row['first_name']; ?>" required />
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" name="lname" style="width:20em;" placeholder="<?php echo $profileLname; ?>" value="<?php echo $row['last_name']; ?>" required />

          </div>
          <div class="form-group">
            <label>Major</label>
            <input type="text" class="form-control" name="major" style="width:20em;" placeholder="Add your major" required value="<?php echo $row['major']; ?>" />
          </div>
          <p>
                <select name="Major">
                    <option value="">Select...</option>
                    <option value="">Architectural History</option>
                    <option value="">Architecture</option>
                    <option value="">Archaelogy</option>
                    <option value="">Urban and Environmental Planning</option>
                    <option value="">Dance</option>
                    <option value="">Drama</option>
                    <option value="">Studio Art</option>
                    <option value="">Biology</option>
                    <option value="">Cognitive Science</option>
                    <option value="">Human Biology</option>
                    <option value="">Neuroscience</option>
                    <option value="">Biomedical Engineering</option>
                    <option value="">Chemistry</option>
                    <option value="">Classics</option>
                    <option value="">Chemical Engineering</option>
                    <option value="">Commerce</option>
                    <option value="">Computer Science (B.A.)</option>
                    <option value="">Computer Science (B.S.)</option>
                    <option value="">Environmental Sciences</option>
                    <option value="">Computer Engineering</option>
                    <option value="">Electrical Engineering</option>
                    <option value="">Early Childhood Education</option>
                    <option value="">Elementary Education</option>
                    <option value="">Kinesiology</option>
                </select>
             </p>
             <div class="form-group">
            <label> Second Major</label>
            <input type="text" class="form-control" name="major" style="width:20em;" placeholder="Add your major" required value="<?php echo $row['major']; ?>" />
          </div>
          <p>
                <select name="Major">
                    <option value="">Select...</option>
                    <option value="">Architectural History</option>
                    <option value="">Architecture</option>
                    <option value="">Archaelogy</option>
                    <option value="">Urban and Environmental Planning</option>
                    <option value="">Dance</option>
                    <option value="">Drama</option>
                    <option value="">Studio Art</option>
                    <option value="">Biology</option>
                    <option value="">Cognitive Science</option>
                    <option value="">Human Biology</option>
                    <option value="">Neuroscience</option>
                    <option value="">Biomedical Engineering</option>
                    <option value="">Chemistry</option>
                    <option value="">Classics</option>
                    <option value="">Chemical Engineering</option>
                    <option value="">Commerce</option>
                    <option value="">Computer Science (B.A.)</option>
                    <option value="">Computer Science (B.S.)</option>
                    <option value="">Environmental Sciences</option>
                    <option value="">Computer Engineering</option>
                    <option value="">Electrical Engineering</option>
                    <option value="">Early Childhood Education</option>
                    <option value="">Elementary Education</option>
                    <option value="">Kinesiology</option>
                </select>
             </p>
          <div class="form-group">
            <label>Concentration</label>
            <input type="text" class="form-control" name="concentration" style="width:20em;" placeholder="Add your concentration" value=" <?php echo $row['concentration']; ?> "/>
          </div>
            <p>
                <select name="Concentration">
                    <option value="">Select...</option>
                </select>
             </p>
          <div class="form-group">
                <input type="save" class="btn btn-primary" value="Save Changes">
                <input type="cancel" class="btn btn-secondary ml-2" value="Cancel">
            </div>
        </form>
    </div>
</body>
</html>



