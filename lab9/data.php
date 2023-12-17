<?php
session_start();

if (isset($_SESSION['created']) && (time() - $_SESSION['created'] > $_SESSION['lifetime'])) {
    session_unset();
    session_destroy();
}

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Athens, Greece, city, information, data, numbers, population, area, geography">
    <meta name="description"
        content="This website contains various data regarding Athens, both numerical and categorical.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5776/5776762.png">
    <?php echo $style; ?>
    <script src="backend/keyevents.js" defer></script>
    <script src="backend/collectionevents.js" defer></script>
    <title>Athens in specifics</title>
    <style>
        body {
            background: no-repeat fixed url(images/data-bg.jpg);
        }
    </style>
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
                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Login';?>
                </a></li>
            </ul>
        </nav>
    </header>

    <main class="main-margin">
        <h1>Athens in specifics</h1><br>
        <table id="administrative">
            <tr>
                <th colspan="2">Administrative data</th>
            </tr>
            <tr>
                <td>Administrative region</td>
                <td>Attica</td>
            </tr>
            <tr>
                <td>Districts</td>
                <td>7</td>
            </tr>
            <tr>
                <td>Mayor</td>
                <td>Kostas Bakoyannis</td>
            </tr>
        </table>
        <br>
        <table id="geographic">
            <tr>
                <th colspan="2">Geographic data</th>
            </tr>
            <tr>
                <td>Geographic region</td>
                <td>Central Greece</td>
            </tr>
            <tr>
                <td>Elevation</td>
                <td>
                    <table id="elevation">
                        <tr>
                            <th colspan="2">Point</th>
                        </tr>
                        <tr>
                            <td>Highest</td>
                            <td>338 m</td>
                        </tr>
                        <tr>
                            <td>Lowest</td>
                            <td>70.1 m</td>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table id="numbers">
            <tr>
                <th colspan="4">Athens in numbers</th>
            </tr>
            <tr>
                <th>Region</th>
                <th>Area</th>
                <th>Population</th>
                <th>Density</th>
            </tr>
            <tr>
                <td>Municipality</td>
                <td>38.96 km²</td>
                <td>643 452</td>
                <td>16 515/km²</td>
            </tr>
            <tr>
                <td>Urban area</td>
                <td>412 km²</td>
                <td>3 059 764</td>
                <td>7 426/km²</td>
            </tr>
            <tr>
                <td>Metro area</td>
                <td>2 928.7 km²</td>
                <td>3 638 281</td>
                <td>1 242/km²</td>
            </tr>
        </table>
        <br>
        <table id="miscellaneous">
            <tr>
                <th colspan="3">Miscellaneous</th>
            </tr>
            <tr>
                <td rowspan="2">Timezone</td>
                <td colspan="2">
                    UTC+2<br>
                    Eastern European Time
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    UTC+3<br>
                    Eastern European Summer Time
                </td>
            </tr>
            <tr>
                <td rowspan="2">GDP</td>
                <td>Total</td>
                <td>€75.1 billion </td>
            </tr>
            <tr>
                <td>Per capita</td>
                <td>€20 600</td>
            </tr>
            <tr>
                <td>Patron saint</td>
                <td colspan="2">Dionysius the Areopagite</td>
            </tr>
        </table>
        <button id="dataButton">Statistics</button>
            <p id="statisticsInfo"></p> 
        <br>
        <p>Source: <a href="https://en.wikipedia.org/wiki/Athens">Athens - Wikipedia</a></p>
        <br><br>
        <aside>
            <p>
                According to a visitor survey conducted by Athenian hotels in 2022,<br>
                the overall level of satisfaction with visits to Athens reached<br>
                a <mark>staggering</mark> <meter value="84" min="0" max="100">8.4 out of 10</meter> <mark>8.4</mark>!
            </p>
        </aside>
    </main>
    <br>
    
    <footer class="main-margin">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>
</body>

</html>