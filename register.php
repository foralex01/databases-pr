<!-- code from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php -->

<?php
// Include config file
require_once "connect-db.php";
 
// Define variables and initialize with empty values
$cid = $password = $confirm_password = "";
$first_name = $last_name = "";
$username_err = $password_err = $confirm_password_err = $name_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validate username
    if(empty(trim($_POST["cid"]))) {
        $username_err = "Please enter a computing ID.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["cid"]))) {
        $username_err = "Computing ID can only contain letters and numbers.";
    } else {
        // Prepare a select statement
        $sql = "SELECT cid FROM Users WHERE cid = :cid";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":cid", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["cid"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This computing ID already has an account.";
                } else {
                    $cid = trim($_POST["cid"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //Get Name
    if(empty(trim($_POST["first_name"])) || empty(trim($_POST["last_name"]))) {
        $name_error = "Please enter your first and last name";
    }
    else {
        $first_name = trim($_POST["first_name"]);
        $last_name = trim($_POST["last_name"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_error)){

        $sql2 = "INSERT INTO Users (cid, password) VALUES (:cid, :password)";

        if($stmt2 = $db->prepare($sql2)){
            // Bind variables to the prepared statement as parameters
            $stmt2->bindParam(":cid", $param_username, PDO::PARAM_STR);
            $stmt2->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $cid;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmterror2 = $stmt2->execute()){
                // Redirect to login page
                // header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt2);
        }
        
        // Prepare an insert statement
        $sql = "INSERT INTO Student (cid, first_name, last_name) VALUES (:cid, :first_name, :last_name)";

        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":cid", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $cid;
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            
            // Attempt to execute the prepared statement
            if($stmterror = $stmt->execute()){
                // Redirect to login page
                // header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
        //if both statements executed properly, then reroute to login page
        if($stmterror && $stmterror2) {

            session_start();
                            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["cid"] = $cid; 

            header("location: home.php");
        }

    }
    
    // Close connection
    unset($pdo);
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
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required >
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required >
            </div>
            <span class="invalid-feedback"><?php echo $name_error; ?></span>
            <div class="form-group">
                <label>Computing ID</label>
                <input type="text" name="cid" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cid; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>