<?php
require("connect-db.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (!empty($_GET['searchBtn']) && ($_GET['searchBtn'] == "Search"))
    {
        if (!empty($_GET['query']))
        {
            
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="author" content="Alexandra Martin, Henry Todd, Matthew Lunsford, Rebecca Chung"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <?php include('index.php');?>
    <a>TODO: create search bar content</a>

    <form action="search.php" method="GET">
        <input type="text" name="query" />
        <input type="submit" name="searchBtn" value="Search" />
    </form>
<body>
</html>