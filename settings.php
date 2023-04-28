<?php
session_start();
require("connect-db.php");
// Check if the user is logged in first 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$cid = $first_name = $last_name = $major = $concentration = "";
$first_name_err = $last_name_err = $major_err = $concentration_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate first name
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your first name.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }
    // Validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }
    // Validate major
    if(!empty(trim($_POST["major"]))){
        $major = trim($_POST["major"]);
    }
    // Validate concentration
    if(!empty(trim($_POST["concentration"]))){
        $concentration = trim($_POST["concentration"]);
    }
    // Check input errors before updating the database
    if(empty($firstname_err) && empty($lastname_err) && empty($major_err) && empty($concentration_err)){
        // Prepare an update statement
        $sql = "UPDATE Users SET firstname = :firstname, lastname = :lastname, major = :major, concentration = :concentration WHERE cid = :cid";
         
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":cid", $param_cid);
            $stmt->bindParam(":first_name", $param_first_name);
            $stmt->bindParam(":last_name", $param_last_name);
            $stmt->bindParam(":major", $param_major);
            $stmt->bindParam(":concentration", $param_concentration);
            
            // Set parameters
            $param_cid = $_SESSION["username"];
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_major = $major;
            $param_concentration = $concentration;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to the profile page
                header("location: profile.php");
                exit();
            } else{
                echo "Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
} else{
    // Retrieve user information from database
    $sql = "SELECT first_name, last_name, major, concentration FROM Users WHERE cid = :cid";
    
    if($stmt = $db->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":cid", $param_username);
        
        // Set parameters
        $param_username = $_SESSION["username"];
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Check if username exists, if yes then retrieve user information
            if($stmt->rowCount() == 1){
                if($row = $stmt->fetch()){
                    $first_name = $row["firstname"];
                    $last_name = $


