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
    <meta name="keywords" content="Cookies, darkmode, rainbowmode">
    <meta name="description" content="This site shows informations about cookies.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5473/5473473.png">
    <?php echo $style;?>
    <title>Cookie Diagnostic Page</title>
</head>

<body>
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
    <h1>Cookie Diagnostic Page</h1>

    <?php
    if (isset($_COOKIE[session_name()])) {
        echo '<p>Content of the ' . session_name() . ' cookie: ' . htmlspecialchars($_COOKIE[session_name()]) . '</p>';
    } else {
        $session_name = session_name();
        echo "<p>The $session_name cookie is not set.</p>";
    }

    if (isset($_COOKIE['darkMode'])) {
        echo '<p>Content of the "darkMode" cookie: ' . htmlspecialchars($_COOKIE['darkMode']) . '</p>';
    } else {
        echo '<p>The "darkMode" cookie is not set.</p>';
    }

    if (isset($_COOKIE['rainbowMode'])) {
        echo '<p>Content of the "rainbowMode" cookie: ' . htmlspecialchars($_COOKIE['rainbowMode']) . '</p>';
    } else {
        echo '<p>The "rainbowMode" cookie is not set.</p>';
    }

    if (isset($_COOKIE['backgroundColor'])) {
        echo '<p>Content of the "backgroundColor" cookie in the form: ' . htmlspecialchars($_COOKIE['backgroundColor']) . '</p>';
    } else {
        echo '<p>The "backgroundColor" cookie is not set.</p>';
    }

    if (isset($_COOKIE['textColor'])) {
        echo '<p>Content of the "textColor" cookie in the form: ' . htmlspecialchars($_COOKIE['textColor']) . '</p>';
    } else {
        echo '<p>The "textColor" cookie is not set.</p>';
    }

    if (isset($_COOKIE['fontFamily'])) {
        echo '<p>Content of the "fontFamily" cookie in the form: ' . htmlspecialchars($_COOKIE['fontFamily']) . '</p>';
    } else {
        echo '<p>The "fontFamily" cookie is not set.</p>';
    }
    ?>

    <p><a href="main.php">Back to Home</a></p>
</body>

</html>
