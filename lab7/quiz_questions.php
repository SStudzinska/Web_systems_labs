<?php
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $olympicsInterval = $_POST["olympics-interval"] ?? '';
    $lowestPoint = $_POST["lowest-point"] ?? '';

    if (!empty($olympicsInterval) && !preg_match("/^\d+$/", $olympicsInterval)) {
        $errors[] = "Wrong number input in Question 5. Must be an integer.";
    }

    if (!empty($lowestPoint) && !preg_match("/^\d+.\d{1,2}$/", $lowestPoint)) {
        $errors[] = "Wrong height input in Question 8. Must be a decimal (with 2 decimal places at most).";
    }

    if (empty($errors)) {
        session_start();

        $_SESSION = [
            "city-size"         => $_POST["city-size"] ?? '',
            "parthenon-name"    => $_POST["parthenon-name"] ?? '',
            "acropolis-name"    => $_POST["acropolis-name"] ?? '',
            "athens-pictures"   => $_POST["athens-pictures"] ?? [],
            "olympics-interval" => $_POST["olympics-interval"] ?? '',
            "government-name"   => $_POST["government-name"] ?? '',
            "syntagma-name"     => $_POST["syntagma-name"] ?? '',
            "lowest-point"      => $_POST["lowest-point"] ?? ''
        ];

        header("Location: quiz_answers.php");
        die();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Athens, Greece, city, information, quiz, trivia, questions">
    <meta name="description" content="On this site you can take a trivia quiz about Athens.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5776/5776762.png">
    <link rel="stylesheet" type="text/css" href="stylesheets/mainsheet.css">
    <script src="backend/keyevents.js" defer></script>
    <title>Athens – trivia quiz</title>
</head>

<body id="quiz-body">
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <fieldset id="quiz-questions">
                <legend>Quiz</legend>
                <div>
                    <label for="city-size">
                        <i>Question 1</i>. Where does Athens place in terms of population size,
                        compared to other cities in the European Union?
                    </label>
                    <br>
                    <select id="city-size" name="city-size">
                        <option value="placeholder">Select an answer</option>
                        <optgroup label="Top 10">
                            <option value="first">1st-2nd</option>
                            <option value="third">3rd-6th</option>
                            <option value="seventh">7th-10th</option>
                        </optgroup>
                        <optgroup label="Top 20">
                            <option value="eleventh">11th-15th</option>
                            <option value="sixteenth">16th-20th</option>
                        </optgroup>
                    </select>
                </div>
                <hr>
                <div>
                    <label>
                        <i>Question 2</i>. What is the correct name for the temple dedicated to
                        the goddess Athena?
                    </label>
                    <br>
                    <input type="radio" id="pantheon" name="parthenon-name" value="Pantheon">
                    <label for="pantheon">Pantheon</label>
                    <input type="radio" id="parthenon" name="parthenon-name" value="Parthenon">
                    <label for="parthenon">Parthenon</label>
                    <br>
                    <input type="radio" id="temple-both" name="parthenon-name" value="Both">
                    <label for="temple-both">Both names are correct and interchangeable.</label>
                </div>
                <hr>
                <div>
                    <label for="acropolis-name">
                        <i>Question 3</i>. What is the name of the hill which hosts, among other things,
                        the temple just mentioned?
                    </label>
                    <br>
                    <input type="text" id="acropolis-name" name="acropolis-name">
                </div>
                <hr>
                <div>
                    <label>
                        <i>Question 4</i>. Select pictures showing iconic landmarks or scenery of Athens.
                    </label>
                    <br><br>
                    <input type="checkbox" id="colosseum" name="athens-pictures[]" value="Colosseum">
                    <img src="images/colosseum.jpg" class="zoomable" alt="A large, ancient, circular building."
                        style="width:200px; height:150px">
                    <input type="checkbox" id="acropolis" name="athens-pictures[]" value="Acropolis">
                    <img src="images/acropolis.webp" class="zoomable" alt="A hill with ancient ruins on it."
                        style="width:225px; height:150px">
                    <br>
                    <input type="checkbox" id="theatre" name="athens-pictures[]" value="Theatre">
                    <img src="images/theatre.jpg" class="zoomable" alt="An ancient theatre." style="width:200px; height:150px">
                    <input type="checkbox" id="aztec"  name="athens-pictures[]" value="Aztec">
                    <img src="images/aztec.jpg" alt="An ancient, triangle-shaped temple." class="zoomable"
                        style="width:200px; height:150px">
                </div>
                <hr>
                <div>
                    <label for="olympics-interval">
                        <i>Question 5</i>. Every how many years are the Olympic Games held, which started
                        in their modern form in 1896 in Athens?
                    </label>
                    <br>
                    <input type="number" id="olympics-interval" name="olympics-interval" min="1">
                </div>
                <hr>
                <div>
                    <label>
                        <i>Question 6</i>. Which form of government is Athens said to be the cradle of?
                    </label><br>
                    <input type="radio" id="aristocracy" name="government-name" value="Aristocracy">
                    <label for="aristocracy">Aristocracy</label>
                    <input type="radio" id="oligarchy" name="government-name" value="Oligarchy">
                    <label for="oligarchy">Oligarchy</label>
                    <br>
                    <input type="radio" id="tyranny" name="government-name" value="Tyranny">
                    <label for="tyranny">Tyranny</label>
                    <input type="radio" id="democracy" name="government-name" value="Democracy">
                    <label for="democracy">Democracy</label>
                </div>
                <hr>
                <div>
                    <label for="syntagma-name">
                        <i>Question 7</i>. What is the name of the central square located in
                        the heart of Athens, just next to the Greek Parliament?
                    </label><br>

                    <input type="text" id="syntagma-name" name="syntagma-name">
                </div>
                <hr>
                <div>
                    <label for="lowest-point">
                        <i>Question 8</i>. How high (in meters) is the lowest elevation point in Athens?
                    </label><br>
                    <input type="text" id="lowest-point" name="lowest-point">
                </div>
                <hr>
                <input type="submit" id="button-submit" value="Check answers">
                <input type="reset" value="Clear">
            </fieldset>
        </form>
        <?php
        foreach ($errors as $error) {
            echo '<br><p style="color: red">' . $error . '</p>';
        }
        ?>
    </main>
    <br>
    <footer class="main-margin">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>

<!--     <script src="backend/functions.js"></script>
    <script>
        const quizAnswers = {
            'city-size': 'seventh',
            'parthenon-name': 'parthenon',
            'acropolis-name': 'acropolis',
            'athens-pictures': ['acropolis', 'theatre'],
            'olympics-interval': '4',
            'government-name': 'democracy',
            'syntagma-name': 'syntagma square',
            'lowest-point': '70.1'
        };

        const buttonSubmit = document.getElementById('button-submit');
        buttonSubmit.addEventListener('click', function() {
            calculateScore(quizAnswers);
        });

        const lowestPointInput = document.getElementById('lowest-point');
        const lowestPointInputPrevious = lowestPointInput.value;
        lowestPointInput.addEventListener('input', function() {
            var userInput = document.getElementById('lowest-point').value;
            if (userInput == "")
                return;
            var result = parseFloat(userInput);
            if (Number.isNaN(result)) {
                alert('Invalid input. Please enter a valid floating-point number.');
                document.getElementById('lowest-point').value = lowestPointInputPrevious;
            }
        });
    </script> -->
</body>

</html>