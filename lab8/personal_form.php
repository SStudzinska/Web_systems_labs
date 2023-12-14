<?php
session_start();

if (isset($_SESSION['created']) && (time() - $_SESSION['created'] > $_SESSION['lifetime'])) {
    session_unset();
    session_destroy();
}

$name = $surname = $birthMonth = $email = $phonenumber = '';
$errors = [];
$expiration_time = time() + 60;

if (!isset($_SESSION['authenticated']) or !$_SESSION['authenticated']) {
    header('Refresh: 3; URL=login.php');
    echo '<br><br><h2 style="text-align: center">You must log in to access this page.</h2>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["personal-form"])){
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $birthMonth = $_POST["birthMonth"];
        $email = $_POST["email"];
        $phonenumber = $_POST["phonenumber"];

        $cleanedName = preg_replace('/\d/', '', $name);
        $cleanedSurname = preg_replace('/\d/', '', $surname);


        if (!empty($cleanedName) && !preg_match("/^[\p{L} ]+$/u", $cleanedName)) {
            $errors[] = "Wrong name input!";
        }

        if (!preg_match("/^[\p{L} ]+$/u", $cleanedSurname)) {
            $errors[] = "Wrong surname input!";
        }

        $allowedMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (!empty($birthMonth) && !in_array($birthMonth, $allowedMonths)) {
            $errors[] = "Wrong birth month!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Wrong email input!";
        }

        if (!empty($phonenumber)) {
            if (!preg_match('/^\+\d{2} \d{3}-\d{3}-\d{3}$/', $phonenumber)) {
                $errors[] = "Wrong phone input!";
            }
        }   

        if (empty($errors)) {
            header("Location: personal_form_aux.php");
            die();
        }

    }
    elseif(isset($_POST["styles"])){
        if(isset($_POST['backgroundColor']) && !empty($_POST['backgroundColor'])){
                $backgroundColor = $_POST["backgroundColor"];
                setcookie('backgroundColor', $backgroundColor, $expiration_time, "/");
            }
        
        if(isset($_POST['textColor']) && !empty($_POST['textColor'])){
                $textColor = $_POST["textColor"];
                setcookie('textColor', $textColor, $expiration_time, "/");
            }
        
        if(isset($_POST['fontFamily']) && !empty($_POST['fontFamily'])){
                $fontFamily = $_POST["fontFamily"];
                setcookie('fontFamily', $fontFamily, $expiration_time, "/");
            }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
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
    <meta name="keywords" content="information, yourself, name, surname, birthday, email, phone">
    <meta name="description" content="This website contains a form to fill with personal information about yourself.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5776/5776762.png">
    <?php echo $style; ?>
    <?php echo $style2; ?>
    <!-- <style>
        body {
            font:;
        }
    </style> -->
    <script src="backend/keyevents.js" defer></script>
    <script src="backend/collectionevents.js" defer></script>
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
                <li style="float:right"><a href="login.php">
                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Login';?>
                </a></li>
            </ul>
        </nav>
        <?php if (!isset($_SESSION['authenticated']) or !$_SESSION['authenticated']) : ?>
        <?php else : ?>
        <br>&nbsp;&nbsp;&nbsp;
        <form method="post" action=<?php echo $_SERVER['PHP_SELF'] ?> name="styles">
        <input type="hidden" name="styles" value="1">
        <label for="background-color-changer">Background</label>
        <input type="color" name="backgroundColor" id="background-color-changer" value=<?= isset($_COOKIE['backgroundColor']) ? $_COOKIE['backgroundColor']: "#f5f5dc"; ?> onchange="changeBackgroundColor()">
        <label for="text-color-changer">Text</label>
        <input type="color" name="textColor" id="text-color-changer"  value=<?= isset($_COOKIE['textColor']) ? $_COOKIE['textColor']:"#000000"; ?> onchange="changeTextColor()">
        <label for="font-family-changer">Font</label>
        <select id="font-family-changer" name="fontFamily" onchange="changeFontFamily()">
        <option value="Verdana" <?= isset($_COOKIE['fontFamily']) && $_COOKIE['fontFamily'] == 'Verdana' ? 'selected' : ''; ?>>Verdana</option>
        <option value="Geneva" <?= isset($_COOKIE['fontFamily']) && $_COOKIE['fontFamily'] == 'Geneva' ? 'selected' : ''; ?>>Geneva</option>
        <option value="Tahoma" <?= isset($_COOKIE['fontFamily']) && $_COOKIE['fontFamily'] == 'Tahoma' ? 'selected' : ''; ?>>Tahoma</option>
        <option value="Arial" <?= isset($_COOKIE['fontFamily']) && $_COOKIE['fontFamily'] == 'Arial' ? 'selected' : ''; ?>>Arial</option>
        <option value="Times New Roman" <?= isset($_COOKIE['fontFamily']) && $_COOKIE['fontFamily'] == 'Times New Roman' ? 'selected' : ''; ?>>Times New Roman</option>
        <option value="Courier New" <?= isset($_COOKIE['fontFamily']) && $_COOKIE['fontFamily'] == 'Courier New' ? 'selected' : ''; ?>>Courier New</option>
        <div><input type='submit' value='Submit changes'></div>
        </select>
        </form>
        <?php endif; ?>
    </header>
    
    <?php if (!isset($_SESSION['authenticated']) or !$_SESSION['authenticated']) : ?>
    <?php else : ?>
    <main class="main-margin">
        <h1 id="title">Personal form</h1>
        <input type="button" id="button-change-title" value="Change title">
        <br><br>
        <form name="personal-form" id="personal-form" class="personal-form" autocomplete="on" action=<?php echo $_SERVER['PHP_SELF'] ?> method="post">
            <div>
            <input type="hidden" name="personal-form" value="1">
            <input type="text" name="name" id="name" autocomplete="given-name" autofocus>
                <label for="name">Name</label>
            </div>
            <hr>
            <div>
                <input type="text" name="surname" id="surname" autocomplete="family-name" required>
                <label for="surname">Surname</label>
            </div>
            <hr>
            <div>
                <input list="months" id="birthMonth" name="birthMonth" autocomplete="bday-month">
                <datalist id="months">
                    <option value="January">
                    <option value="February">
                    <option value="March">
                    <option value="April">
                    <option value="May">
                    <option value="June">
                    <option value="July">
                    <option value="August">
                    <option value="September">
                    <option value="October">
                    <option value="November">
                    <option value="December">
                </datalist>
                <label for="birthMonth">Birth month</label>
            </div>
            <hr>
            <div>
                <input type="email" name="email" id="email" autocomplete="email" required>
                <label for="email">E-mail</label>
                <div id="email-error" class="error"></div>
            </div>
            <hr>
            <div>
                <input type="tel" name="phonenumber" id="phonenumber" autocomplete="tel"
                    title="Fill in your phone number using the format +XX XXX-XXX-XXX">
                <label for="phonenumber">Phone number</label>
                <div id="phonenumber-hint" class="hint"></div>
            </div>
            <hr>
            <input type="submit" id="button-submit" value="Continue">
            <input type="reset" id="button-reset">
        </form>
        <?php
            foreach ($errors as $error) {
                echo '<p style="color: red;">' . $error . "<br>" . '</p>';
            }
        ?>
    </main>
    <br>
 
    <button id="dataButton">Statistics</button>
    <p id="statisticsInfo"></p> 
    <footer class="main-margin">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>

    <script src="backend/functions.js"></script>
    <script src="backend/styles.js"></script>
    <script src="backend/forms.js"></script>
    <script>
        buttonChangeTitle = document.getElementById("button-change-title");
        buttonChangeTitle.addEventListener("click", () => {
            document.getElementById("title").innerHTML = window.prompt(`Enter a new page title:`);
        });
    </script>
    <?php endif; ?>
</body>
</html>