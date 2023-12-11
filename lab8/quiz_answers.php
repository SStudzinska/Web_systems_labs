<?php
session_start();

define('QUIZ_ANSWERS', [
    'city-size'         => 'seventh',
    'parthenon-name'    => 'parthenon',
    'acropolis-name'    => 'acropolis',
    'athens-pictures'   => ['Acropolis', 'Theatre'],
    'olympics-interval' => 4,
    'government-name'   => 'democracy',
    'syntagma-name'     => 'syntagma square',
    'lowest-point'      => 70.1
]);

$userAnswers = [
    'city-size'         => validateInput($_SESSION['city-size'] ?? ''),
    'parthenon-name'    => validateInput($_SESSION['parthenon-name'] ?? ''),
    'acropolis-name'    => validateInput($_SESSION['acropolis-name'] ?? ''),
    'athens-pictures'   => validateInput($_SESSION['athens-pictures'] ?? []),
    'olympics-interval' => (int) validateInput($_SESSION['olympics-interval'] ?? ''),
    'government-name'   => validateInput($_SESSION['government-name'] ?? ''),
    'syntagma-name'     => validateInput($_SESSION['syntagma-name'] ?? ''),
    'lowest-point'      => (float) validateInput($_SESSION['lowest-point'] ?? '')
];

$correctAnswerCount = 0;
$questionCount = count(QUIZ_ANSWERS);
$quizAnswers = constant('QUIZ_ANSWERS');
for (reset($quizAnswers); $question = key($quizAnswers); next($quizAnswers)) {
    $userAnswer = $userAnswers[$question];
    $quizAnswer = QUIZ_ANSWERS[$question];

    if (is_array($userAnswer)) {
        sort($userAnswer);
        sort($quizAnswer);
        $correctAnswerCount += ($userAnswer === $quizAnswer);
    } else {
        if (is_string($userAnswer)) {
            $stringDifference = strcmp(strtolower($userAnswer), $quizAnswer);
            $correctAnswerCount += $stringDifference == "0";
        } else {
            $correctAnswerCount += ($userAnswer === $quizAnswer);
        }
    }
}

$resultMessage = "You got <span style=\"color: green\">$correctAnswerCount</span> 
                  out of <span style=\"color: red\">$questionCount</span> answers right.";


function validateInput($input) {
    if (is_array($input)) {
        $input = array_map('validateInput', $input);
    } else {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
    }
    return $input;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Athens, Greece, city, information, quiz, trivia, answers">
    <meta name="description" content="On this site you can verify your answers to the trivia quiz about Athens.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5776/5776762.png">
    <link rel="stylesheet" type="text/css" href="stylesheets/mainsheet.css">
    <script src="backend/keyevents.js" defer></script>
    <title>Athens – trivia quiz</title>
</head>

<body>
    <header id="header">
        <nav class="menu">
            <ul>
                <li><a href="main.html">Homepage</a></li>
                <li class="submenu"><a href="#">Information</a>
                    <ul>
                        <li class="sub-submenu"><a href="#">About Athens</a>
                            <ul>
                                <li><a href="places_people.html">Places & People</a></li>
                                <li><a href="data.html">Data</a></li>
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
                                <li><a href="numbers.html">Guess The Number </a></li>
                            </ul>
                        </li>
                        <li><a href="photos.zip">Download photos</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <main class="main-margin">
        <h1>Athens – trivia quiz</h1>
        <?php 
        if (isset($resultMessage)) {
            echo '<p style="font-weight: bold; font-size: 1.1em; margin: 1.4em">' . $resultMessage . '</p>';
        }
        ?>
        <fieldset id="quiz-answers">
            <legend>Answers</legend>
            <details>
                <summary>
                    <i>Question 1</i>. Where does Athens place in terms of population size,
                    compared to other cities in the European Union?
                </summary>
                Athens is currently the <b>8th</b> largest urban area in the European Union.
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 2</i>. What is the correct name for the temple dedicated to
                    the goddess Athena?
                </summary>
                The correct name for the temple is <b>Parthenon</b>.
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 3</i>. What is the name of the Athenian hill which hosts,
                    among other things, the temple just mentioned?<br>
                </summary>
                The name of the landmark hill is <b>Acropolis</b>.
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 4</i>. Select pictures showing iconic landmarks or scenery of Athens.
                </summary>
                <img src="images/acropolis.webp" alt="A hill with ancient ruins on it." class="zoomable"
                    style="width:300px; height:200px">
                <p>This picture shows <b>the Acropolis of Athens.</b></p>
                <div id="float-separator"></div>
                <img src="images/theatre.jpg" alt="An ancient theatre." class="zoomable"
                    style="width:266px; height:200px">
                <p>This image portrays <b>the Odeon of Herodes Atticus</b>, which is an ancient
                    theatre in <b>Athens</b>.</p>
                <aside>
                    The remaining pictures were of Rome's Colosseum and an Aztec temple.
                </aside>
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 5</i>. Every how many years are the Olympic Games held, which started
                    in their modern form in 1896 in Athens?
                </summary>
                There is an Olympic Games event held <b>every two years</b> overall. However,
                each individual type of games — Summer or Winter — is held <b>every four years</b>.
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 6</i>. Which form of government is Athens said to be the cradle of?
                </summary>
                <b>Democracy</b> is the system of goverment first established in Athens around 508 BC.
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 7</i>. What is the name of the central square located in
                    the heart of Athens, just next to the Greek Parliament?
                </summary>
                <b>Syntagma Square</b> is the name of the bustling hub of the city.
            </details>
            <hr>
            <details>
                <summary>
                    <i>Question 8</i>. How high (in meters) is the lowest elevation point in Athens?
                </summary>
                The lowest elevation point in Athens is <b>70.1</b>m.
            </details>
        </fieldset><br>

        <form>
            <label for="feedback">
                Feel free to share any feedback you may have regarding the quiz:
            </label><br>
            <input type="text" id="respondent-name" name="respondent-name" placeholder="Your name"><br>
            <input type="email" id="respondent-email" name="respondent-email" placeholder="Your address e-mail"><br>
            <textarea id="feedback" name="feedback" rows="4" cols="50" maxlength="200"
                placeholder="Feedback – up to 200 characters"></textarea><br>
            <input type="button" value="Submit" onclick="alert('Thank you for your feedback!')">
        </form>
    </main>
    <br>
    <footer class="main-margin">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>
</body>

</html>