<?php
require('connect-db.php');
require('search-db.php');

$searchResults = getAllCourses();
// var_dump($searchResults);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['searchBtn']) && ($_POST['searchBtn'] == "Search"))
    {
        $searchText = $_POST['searchText'];
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
    <?php include('home.php');?>
    <div class="container">
        <br/>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form class="card card-sm" action="search.php" method="post">
                    <div class="card-body row no-gutters align-items-center">
                        <div class="col">
                            <input class="form-control form-control-lg form-control-borderless" type="text" name="searchText" placeholder="Search by keyword" required />
                        </div>
                        <div class="col-auto">
                            <input class="btn btn-lg btn-success" type="submit" name="searchBtn" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </br>

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