<!-- redirects right to login page -->

<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php"); // change from welcome.php to whatever we want our first page to be
    exit;
}
else {
    header('Location: login.php');
    exit;
}
?>
