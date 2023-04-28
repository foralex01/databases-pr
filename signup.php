<?php
require("connect-db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <meta charset="UTF-8">  
    <meta name="author" content="Alexandra Martin, Henry Todd, Matthew Lunsford, Rebecca Chung"> 
        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <h1>Create An Account</h1>
    <form action="process-signup.php" method="post" id="signup">
        
        <div>
            <label for="id">Computing ID</label>
            <input type="text" id="id" name="id">
        </div>
        <div>
            <label for="Fname">First Name</label>
            <input type="Fname" id="Fname" name="Fname">
        </div>
        <div>
            <label for="Lname">Last Name</label>
            <input type="Lname" id="Lname" name="Lname">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        <button>Create Account</button>
    </form>


</body>
</html>

