<?php
require('connect-db.php');
require('search-db.php');

// $searchResults = getAllCourses();
$searchResults;
var_dump($searchResults);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['searchBtn']) && ($_POST['searchBtn'] == "Search"))
    {
        echo $searchText = $_POST['searchText'];
        $searchResults = searchCourses($searchText);
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

    <form action="search.php" method="post">
        <input type="text" name="searchText" required />
        <input type="submit" name="searchBtn" value="Search" />
    </form>

    <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Course Code</th>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <?php foreach($searchResults as $row): ?>
                        <tr>
                            <td><?php echo $row['dept_abbr']; ?></td>
                            <td><?php echo $row['course_code']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
    </div>
<body>
</html>