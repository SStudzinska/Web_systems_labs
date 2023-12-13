<?php

$successMsg = $errorMsg = $additionalInfo = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update form data variables
    $favcolor = $_POST["favcolor"];
    $importantMonthYear = $_POST["important-month-year"];
    $satisfaction = $_POST["satisfaction"];
    $commonSearch = $_POST["common-search"];
    $favoriteWebsite = $_POST["favorite-website"];
    if (empty($favcolor) || empty($importantMonthYear) || empty($satisfaction) || empty($commonSearch) || empty($favoriteWebsite)) {
        $errorMsg = 'Please fill in all fields.';
    } elseif (!preg_match('/^(https?|ftp):\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\/[^\s]*)?$/', $favoriteWebsite)) {
        $errorMsg = 'Invalid favorite website format. Please enter a valid HTTPS URL.';
    } else {
        $successMsg = 'Thank you for submitting information!';


        $additionalInfo = 'Client IP Address: ' . $_SERVER['REMOTE_ADDR'] . '<br>';
        $additionalInfo .= 'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . '<br>';

        $currentDate = new DateTime();
        $favoriteDate = DateTime::createFromFormat('Y-m', $importantMonthYear);
        $monthsDifference = $currentDate->diff($favoriteDate)->m + $currentDate->diff($favoriteDate)->y * 12 ;
        $additionalInfo .= 'Months since favorite month and year: ' . $monthsDifference . '<br>';
        if ($currentDate->format('Y-m') == $favoriteDate->format('Y-m')) {
            $additionalInfo .= 'The current month and year are the same as the favorite month and year.<br>';
        } else {
            $additionalInfo .= 'The current month and year are different from the favorite month and year.<br>';
        }
    }
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

$backgroundColor = isset($_COOKIE['backgroundColor']) ? $_COOKIE['backgroundColor'] : '#f5f5dc';
$textColor = isset($_COOKIE['textColor']) ? $_COOKIE['textColor'] : '#000000';
$fontFamily = isset($_COOKIE['fontFamily']) ? $_COOKIE['fontFamily'] : 'Verdana';


$style2 = "
    <style>
        body {
            background-color: $backgroundColor !important;
            color: $textColor !important;
        }

        button, a, p, label, option, h1, h2, h3 {
            font-family: $fontFamily !important;
        }
    </style>
";

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="information, yourself, favorite, common, important">
    <meta name="description" content="Here on this site you can provide additonal information about yourself.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5776/5776762.png">
    <?php echo $style; ?>
    <?php echo $style2; ?>
    <script src="backend/keyevents.js" defer></script>
    <title>Personal form</title>
</head>

<body id="form">
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
            </ul>
        </nav>
        <br>&nbsp;&nbsp;&nbsp;
    </header>

    <main class="main-margin">
        <h1>Personal form</h1>
        <form class="personal-form" id="personal-form-aux" method="post">
            <div>
                <label for="favorite-color">Select your favorite color:</label>
                <input type="color" id="favcolor" name="favcolor">
            </div>
            <hr>
            <div>
                <label for="important-month-year">What is some month and year you hold dear?</label>
                <input type="month" id="important-month-year" name="important-month-year">
            </div>
            <hr>
            <div>
                <label for="satisfaction">How satisfied are you with our website?</label>
                <input type="range" id="satisfaction" name="satisfaction" min="1" max="5">
            </div>
            <hr>
            <div>
                <label for="common-search">What is the most common thing you search for online?</label>
                <input type="search" name="common-search" id="common-search"
                    placeholder="Enter your answer here (eg. shopping Sunday)" size="40">
            </div>
            <hr>
            <div>
                <label for="favorite-website">Enter a link to your favorite website:</label>
                <input type="url" name="favorite-website" id="favorite-website"
                    placeholder="Paste your link here (eg. https://athens-greece.com)" size="42">
                <input type="button" value="Open" onclick="openFavoriteWebsite()">
            </div>
            <hr>
            <input type="submit" id="button-submit">
            <input type="reset" id="button-reset">
        </form>
        <?php
       if (!empty($errorMsg)) {
        echo '<p style="color: red;">' . $errorMsg . '</p>';
    } elseif (!empty($successMsg)) {
        echo '<p style="color: green;">' . $successMsg . '</p>';
        // Display additional information
        if (!empty($additionalInfo)) {
            echo '<p>' . $additionalInfo . '</p>';
        }
    }
        ?>
    </main>
    <br>
    <footer class="main-margin">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>

    <script src="backend/functions.js"></script>
    <script src="backend/styles.js"></script>
    <script src="backend/forms.js"></script>

</script>

</body>

</html>