<?php
require_once "connect-db.php";
require("settings_db.php");

session_start();

ehco $cid = $_SESSION["cid"];

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
  <h1>Your Profile</h1>
<div class="profile-input-field">
        <h3>Keep your profile up-to-date!</h3>
        <form method="post" action="#" >
          <div class="form-group">
            <label>First Name</label>
            <input type="text" class="form-control" name="fname" style="width:20em;" placeholder="Enter your first name" value="<?php echo $row['first_name']; ?>" required />
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" name="lname" style="width:20em;" placeholder="Enter your last name" value="<?php echo $row['last_name']; ?>" required />
          </div>
          <div class="form-group">
            <label>Major(s)</label>
            <input type="text" class="form-control" name="major" style="width:20em;" placeholder="Add your major(s)" required value="<?php echo $row['major']; ?>" />
          </div>
          <div class="form-group">
            <label>Concentration</label>
            <input type="number" class="form-control" name="concentration" style="width:20em;" placeholder="Add your concentration" value="<?php echo $row['concentration']; ?>">
          </div>
          <div class="form-group">
                <input type="save" class="btn btn-primary" value="Save Changes">
                <input type="cancel" class="btn btn-secondary ml-2" value="Cancel">
            </div>
        </form>
    </div>
</body>
</html>



