<?php
session_start();

$_SESSION['lifetime'] = 120;

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }

    $logins = [
        "admin" => "admin", 
        "user" => "password",
        "1" => "1"
    ];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($logins[$username]) && $logins[$username] === $password) {
        $_SESSION['created'] = time();
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        header('Location: '  . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = "Invalid username or password";
    }
}

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
    <title>Login page</title>
    <script src="backend/keyevents.js"></script>
    <style>
        div.center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: auto;
            width: max-content;
        }
        div.login {
            display: grid;
            grid-template-columns: max-content max-content;
            gap: 10px;
        }
        div.login label {
            text-align: right;
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

    <?php if (!isset($_SESSION['authenticated']) or !$_SESSION['authenticated']) : ?>
    <form method="post" action="login.php">
        <div class="center">
            <h2>Login</h2>
            <div class="login">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="username" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter password" name="password" required>
            </div>
            <br>
            <?php 
                if(isset($error)) 
                    echo "<span style=\"text-align: center; color: red; font-weight: bold\">
                            $error 
                        </span><br>"; 
            ?>
            <button type="submit">Login</button>
        </div>
    </form>

    <?php else : ?>
    <form method="post" action="login.php">
        <div class="center">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <button type="submit" name="logout">Logout</button>
        </div>
    </form>  

    <?php endif; ?>
</body>
</html>