<?php

$style='';
if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] === 'true') {
    $style = '<link rel="stylesheet" type="text/css" href="stylesheets/darkmode.css">';
}
else if (isset($_COOKIE["rainbowMode"]) && $_COOKIE["rainbowMode"] === 'true'){
    $style = '<link rel="stylesheet" type="text/css" href="stylesheets/rainbowmode.css">';
}
else {
    $style = '<link rel="stylesheet" type="text/css" href="stylesheets/mainsheet.css">';
}

$servername = 'localhost';
$username = 'student';  
$password = 'student';
$dbname = 'user_database';

$conn = mysqli_connect($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . mysqli_error($conn));
}

$conn->select_db($dbname);

// Function to generate HTML table headers with sorting links
function generateTableHeaders($column, $label, $currentSortColumn, $currentSortOrder)
{
    $sortingSymbol = '';
    $newSortOrder = 'ASC';

    if ($column === $currentSortColumn) {
        $newSortOrder = ($currentSortOrder === 'ASC') ? 'DESC' : 'ASC';
        $sortingSymbol = ($currentSortOrder === 'ASC') ? '↑' : '↓';
    }

    echo "<th><a href='?sort=$column&order=$newSortOrder'>$label $sortingSymbol</a></th>";
}

// Get sorting parameters from the URL
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Validate the sorting parameters to prevent SQL injection
$allowedColumns = ['user_id', 'name', 'surname', 'email', 'phone_number', 'birthdate'];
$sortColumn = in_array($sortColumn, $allowedColumns) ? $sortColumn : 'user_id';
$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

// Query to fetch user_info data with sorting
$sql_fetch_user_info = "SELECT ui.user_id, ui.name, ui.surname, ui.email, ui.phone_number, ui.birthdate
                        FROM user_info ui
                        ORDER BY $sortColumn $sortOrder";

$result = mysqli_query($conn, $sql_fetch_user_info);

if ($result) {
    echo "<table border='1'>";
    echo "<tr>";
    generateTableHeaders('user_id', 'User ID', $sortColumn, $sortOrder);
    generateTableHeaders('name', 'Name', $sortColumn, $sortOrder);
    generateTableHeaders('surname', 'Surname', $sortColumn, $sortOrder);
    generateTableHeaders('email', 'E-mail', $sortColumn, $sortOrder);
    generateTableHeaders('phone_number', 'Phone Number', $sortColumn, $sortOrder);
    generateTableHeaders('birthdate', 'Birthdate', $sortColumn, $sortOrder);
    echo "</tr>";

    while ($row = mysqli_fetch_row($result)) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn3.iconfinder.com/data/icons/vol-2/128/column-512.png">
    <?php echo $style ?>
    <style><?php echo $background?></style>
    <script src="backend/keyevents.js" defer></script>
    <title>Info</title>
</head>
<body>
<header id="header">
        <nav class="menu">
            <ul>
                <li><a href="main.php">Homepage</a></li>
                <li class="submenu"><a href="#">Information</a>
                    <ul>
                        <li class="sub-submenu"><a href="#">About Athens</a>
                            <ul>
                                <li><a href="places_people.php">Places & People</a></li>
                                <li><a href="data.php">Data</a></li>
                            </ul>
                        </li>
                        <li class="sub-submenu"><a href="#">More info</a>
                            <ul>
                                <li><a href="https://en.wikipedia.org/wiki/Athens">Athens wiki</a></li>
                                <li><a href="https://www.thisisathens.org/">Official Athens Guide</a></li>
                                <li><a
                                        href="https://www.google.com/maps?sca_esv=579179295&output=search&q=athens&source=lnms&entry=mc&sa=X&ved=2ahUKEwjBkaTqqqiCAxW__rsIHdczCq0Q0pQJegQIDhAB">Athens
                                        On The Map</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu"><a href="#">Other</a>
                    <ul>
                        <li class="sub-submenu"><a href="#">Forms</a>
                            <ul>
                                <li><a href="personal_form.php">Personal form</a></li>
                            </ul>
                        </li>
                        <li class="sub-submenu"><a href="#">Quizes & Games</a>
                            <ul>
                                <li><a href="quiz_questions.php">Quiz</a></li>
                                <li><a href="numbers.php">Guess The Number </a></li>
                            </ul>
                        </li>
                        <li><a href="photos.zip">Download photos</a></li>
                    </ul>
                </li>
                <li style="float:right"><a href="login.php">
                    <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Login';?>
                </a></li>
            </ul>
        </nav>
    </header>
</body>
