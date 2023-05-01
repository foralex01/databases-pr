<?php
require_once "connect-db.php";
require("settings_db.php");
session_start();
$profileFname;
$profileLname;
//check user logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    $cid = $_SESSION["cid"];
    $profileFname = getFname($cid)['first_name'];
    $profileLname = getLname($cid)['last_name'];  
}
else {
  header("Location: login.php");
  exit;
}

//handle forms
if($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["logout"])) {
    // unset session variables
    $_SESSION["cid"] = null;
    $_SESSION["loggedin"] = false;
    // redirect to login page
    header("Location: login.php");
    exit;
  }
}

//majors for dropdown
$major_names = getMajor();

//current user's majors
$first_concentration = $second_concentration = "";

$first_major = getPrimaryMajor($cid);
if($first_major != null) {
  if(array_key_exists("concentration", $first_major)) {$first_concentration = $first_major['concentration'];}
  $first_major = $first_major["major_name"];
}
else {
  $first_major = "";
}

$second_major = getSecondMajor($cid);
if($second_major != null) {
  if(array_key_exists("concentration", $second_major)) {$second_concentration = $second_major['concentration'];}
  $second_major = $second_major["major_name"];
}
else {
  $second_major = "";
}

if(isset($_POST["savechanges"])) {
    if(isset($_POST["major"])) {
        $new_primary_major = trim($_POST["major"]);
        $new_primary_concentration = trim($_POST["concentration"]);
        if($new_primary_major != "") {
            if($first_major != "") {
                //need to UPDATE primary major
                updatePrimaryMajor($cid, $new_primary_major, $new_primary_concentration);
            } else {
                //need to INSERT primary major for first time
                insertPrimaryMajor($cid, $new_primary_major, $new_primary_concentration);
            }
        } else {
            echo "Please insert a primary major";
        }
    }
    if(isset($_POST["major2"])) {
        $new_second_major = trim($_POST["major2"]);
        $new_second_concentration = trim($_POST["concentration2"]);
        if($new_second_major != "") {
            if($second_major != "") {
                //need to UPDATE second major
                updateSecondMajor($cid, $new_second_major, $new_second_concentration);
            } else {
                //need to INSERT second major for first time
                insertSecondMajor($cid, $new_second_major, $new_second_concentration);
            }
        } else {
            echo "Please insert a second major";
        }
    }
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
<?php include('navbar.php'); ?>
  <h1>Your Profile</h1>
<div class="profile-input-field">
        <h3>Keep your profile up-to-date!</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
          <div class="form-group">
            <label>First Name</label>
            <input type="text" class="form-control" name="fname" style="width:20em;" value="<?php echo $profileFname; ?>" required />
          </div>

          <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" name="lname" style="width:20em;" value="<?php echo $profileLname; ?>" required />
          </div>
          <div class="form-group">
            <label> Add Primary Major: </label>
              <select name="major" id="major" required>
                <option value="select"> Select... </option>
                <option value="none"> None </option>
              <?php foreach ($major_names as $major_name): ?>
            <option value=<?php echo $major_name['major_name']; if ($first_major == $major_name['major_name']) { ?> selected=true <?php }; ?>><?php echo $major_name['major_name']; ?></option>
          <?php endforeach; ?>
              </select>
              </div>
              <div class="form-group">
            <label>Concentration</label>
            <input type="text" class="form-control" name="concentration" style="width:20em;" placeholder= "Add your concentration" value="<?php echo $first_concentration ?>"/>
          </div>
          
            <div class="form-group">
            <label for="major2">Add Second Major:</label>
<select name="major2" id="major2" required>    
                <option value="select"> Select... </option>
                <option value="none"> None </option>
            <?php foreach ($major_names as $major_name): ?>
            <option value=<?php echo $major_name['major_name']; if($second_major == $major_name['major_name']) { ?> selected=true <?php }; ?>><?php echo $major_name['major_name']; ?></option>
          <?php endforeach; ?>
        </select>
            </div>
          <div class="form-group">
            <label>Concentration</label>
            <input type="text" class="form-control" name="concentration2" style="width:20em;" placeholder= "Add your concentration" value="<?php echo $second_concentration; ?>"/>
          </div>
          <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save Changes", name="savechanges">
                <input type="cancel" class="btn btn-secondary ml-2" value="Cancel">
            </div>
          <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Sign Out" name="logout">
          </div>
        </form>
    </div>
</body>
</html>

