<?php
session_start();

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
$db_username = "student";
$db_password = "student";
$db_name = "user_database";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($servername, $db_username, $db_password);

if (!$conn) {
    exit("Connection: failed: " . mysqli_connect_error());
}

if (!$conn->select_db($db_name)) {
    if ($conn->query("CREATE DATABASE IF NOT EXISTS $db_name")) {
        echo "The database has been just created or it already exists\n";
    } else {
        exit("Error creating the database: " . $conn->error);
    }
}

$errors = [];
$successes = [];

$edit_mode = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
$page_header = "Register";
$button_text = "Register";
$readonly = "";

if ($edit_mode) {
    $page_header = "Edit user data";
    $button_text = "Edit";
    $readonly = "readonly";

    $username = $_SESSION['username'];
    $result = $conn->query("SELECT * FROM user_info WHERE user_id = (SELECT id FROM users WHERE username = '$_SESSION[username]')");
    if ($result) {
        foreach ($result->fetch_assoc() as $key => $value) {
            $$key = $value;
        }
    } else {
        $errors[] = "Error fetching user data: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    $continue = true;
    $update_password = true;

    if (!preg_match('/^[a-zA-Z0-9]{4,}$/', $username)) {
        $errors[] = "Invalid username input or username is too short (min. 4 characters).";
        $continue = false;
    }

    if ($edit_mode && empty($password)) {
        $update_password = false;
    } elseif (!preg_match('/^\S{8,}$/', $password)) {
        $errors[] = "Invalid password input or password is too short (min. 8 characters).";
        $continue = false;
    } elseif ($password !== $password_repeat) {
        $errors[] = "Passwords do not match.";
        $continue = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
        $continue = false;
    }

    if (!preg_match("/^[\p{L} ]+$/u", $name)) {
        $errors[] = "Invalid name input.";
        $continue = false;
    }

    if (!preg_match("/^[\p{L} ]+$/u", $surname)) {
        $errors[] = "Invalid surname input.";
        $continue = false;
    }

    if (strtotime($birthdate) > strtotime(date('Y-m-d'))) {
        $errors[] = "Invalid birthdate input.";
        $continue = false;
    }

    if (!empty($phone_number) && !preg_match('/^(?>\+\d{2}){0,1} *\d{3} *\d{3} *\d{3}$/', $phone_number)) {
        $errors[] = "Invalid phone number input.";
        $continue = false;
    }

    foreach ($_POST as $key => $value) {
        $$key = quotemeta($value);
    }

    $sql_check_username = "SELECT * FROM users WHERE username = '$username'";
    if ($continue && $edit_mode) {
        if ($update_password) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            if (!$conn->query("UPDATE users SET password = '$password' WHERE username = '$username'")) {
                $errors[] = "Error updating password: " . $conn->error;
            }
        }
        if ($conn->query(
            "UPDATE user_info 
            SET 
                name = '$name',
                surname = '$surname', 
                email = '$email', 
                phone_number = NULLIF('$phone_number', ''),
                birthdate = '$birthdate' 
            WHERE user_id = (
                SELECT id 
                FROM users 
                WHERE username = '$username'
            )"
        )) {
            $_SESSION['name'] = $name;
            $successes[] = "User data updated successfully.";
        } else {
            $errors[] = "Error updating user data: " . $conn->error;
        }
    } elseif ($continue && $conn->query($sql_check_username)->num_rows == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql_insert_user = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $sql_insert_user_info = "INSERT INTO user_info (user_id, name, surname, email, phone_number, birthdate)
                                VALUES (
                                    (SELECT id FROM users WHERE username = '$username'), 
                                    '$name',
                                    '$surname',
                                    '$email',
                                    NULLIF('$phone_number', ''),
                                    '$birthdate'
                                )";
        if ($conn->query($sql_insert_user) && $conn->query($sql_insert_user_info)) {
            $_SESSION['created'] = time();
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            header('Location: login.php');
        } else {
            $error = "Error registering user: " . $conn->error;
        }
    } elseif ($continue) {
        $errors[] = "User with this username already exists.";
    }
}


function deescape($string) {
    $regex = "/\\\/";
    while (preg_match($regex, $string)) {
        $string = preg_replace($regex, '', $string);
    }
    return $string;
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
    <title>Register page</title>
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
        div.register {
            display: grid;
            grid-template-columns: 0.9fr 1fr;
            gap: 10px;
        }
        div.register label {
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
                    <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Login';?>
                </a></li>
            </ul>
        </nav>
    </header>

    <form method="post" action="register.php">
        <div class="center">
            <h2><?php echo $page_header ?></h2>
            <div class="register">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="username" value="<?php if (isset($username)) echo deescape($username) ?>" required <?php echo $readonly?>>
                <label for="email"><b>E-mail</b></label>
                <input type="email" placeholder="Enter e-mail" name="email" autocomplete="email" value="<?php if (isset($email)) echo deescape($email) ?>" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter password" name="password">
                <label for="password_repeat"><b>Repeat password</b></label>
                <input type="password" placeholder="Repeat password" name="password_repeat">
            </div>
            <br><br>
            <div class="register">
                <label for="name"><b>Name</b></label>
                <input type="text" placeholder="Enter name" name="name" autocomplete="given-name" value="<?php if (isset($name)) echo deescape($name) ?>" required>
                <label for="surname"><b>Surname</b></label>
                <input type="text" placeholder="Enter surname" name="surname" autocomplete="family-name" value="<?php if (isset($surname)) echo deescape($surname) ?>" required>
                <label for="birthdate"><b>Date of birth</b></label>
                <input type="date" name="birthdate" autocomplete="bday" value="<?php echo $birthdate ?? '' ?>">
                <label for="phone_number"><b>Phone number</b></label>
                <input type="tel" placeholder="Enter phone number" name="phone_number" autocomplete="tel" value="<?php if (isset($phone_number)) echo deescape($phone_number) ?>">
            </div>
            <br>
            <?php 
                if(isset($errors)) {
                    foreach ($errors as $error) {
                        echo "<span style=\"text-align: center; color: red; font-weight: bold\">
                                $error 
                            </span><br>";
                    }
                }
                if(isset($successes)) {
                    foreach ($successes as $success) {
                        echo "<span style=\"text-align: center; color: green; font-weight: bold\">
                                $success 
                            </span><br>";
                    }
                }; 
            ?>
            <button type="submit"><?php echo $button_text ?></button>
        </div>
    </form>
</body>
</html>