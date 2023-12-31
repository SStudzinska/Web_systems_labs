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
    <meta name="keywords" content="numbers, guessing, game, fun">
    <meta name="description" content="This is a simple number guessing game.">
    <link rel="icon" type="image/x-icon" href="https://w7.pngwing.com/pngs/222/896/png-transparent-gray-and-black-1-logo-computer-icons-favicon-number-simple-miscellaneous-angle-text-thumbnail.png">
    <?php echo $style; ?>
    <script src="backend/keyevents.js"></script>
    <title>Guess the Number</title>
    <style>
        #result {
            font-size: 18px;
            margin-top: 20px;
        }

        .container {      
            display: flex;  
            justify-content: center;  
            align-items: center;  
        }
   
    </style>
</head>
<body class="numbers-body">
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

    <h1>Guess the Number Game</h1>
    <div class="container">
        <button id ="game">Start the Game</button>
    </div>
    <p id="result"></p>

    <script>
        let targetNumber;
        let remainingAttempts;
        const button = document.getElementById("game")
        button.addEventListener("click", startGame, false)

        function startGame() {
            targetNumber = Math.floor(Math.random() * 100) + 1;
            remainingAttempts = 3;
            document.getElementById('result').textContent = '';

            for (let i = 0; i < 3; i++) {
                const userGuess = window.prompt(`Attempt ${i + 1}: Enter a number between 1 and 100:`);

                if (userGuess === null) {
                    // User clicked Cancel
                    return;
                }

                const parsedGuess = parseInt(userGuess);

                if (isNaN(parsedGuess) || parsedGuess < 1 || parsedGuess > 100) {
                    window.alert('Please enter a valid number between 1 and 100.');
                    i--;
                    continue;
                }

                remainingAttempts--;

                if (parsedGuess === targetNumber) {
                    displayResult(`Congratulations! You guessed the correct number in ${i + 1} attempts.`);
                    break;
                } else {
                    const hint = parsedGuess < targetNumber ? 'higher' : 'lower';
                    if (remainingAttempts > 0) {
                        window.alert(`Wrong guess. Try again! The correct number is ${hint}. Remaining attempts: ${remainingAttempts}`);
                    } else {
                        displayResult(`Sorry, you've run out of attempts. The correct number was ${targetNumber}.`);
                        break;
                    }
                }
            }
        }

        function displayResult(message) {
            document.getElementById('result').textContent = message;
        }
    </script>
</body>
</html>
