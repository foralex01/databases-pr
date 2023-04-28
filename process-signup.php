<?php
require("connect_db.php");

if (empty($_POST["id"])) {
    die("ID is required");
}
if (empty($_POST["Fname"])) {
    die("First name is required");
}
if (empty($_POST["Lname"])) {
    die("Last name is required");
}
if (empty($_POST["password"])) {
    die("Password is required");
}
//confirm that password matches password validation
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords do not match");
}

//store hash password 
//source: https://www.php.net/manual/en/function.password-hash.php
//$hashed_password = hashed_password($_POST["password"], PASSWORD_DEFAULT);
$sql = "INSERT INTO user (id, fname, lname, hashed_password)
VALUES (?, ?, ?)";

print_r($_POST);
//var_dump($hashed_password);

