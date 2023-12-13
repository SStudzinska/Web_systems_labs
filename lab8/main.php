<?php
$style='';
$background='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['darkMode'])) {
        $darkMode = $_POST['darkMode'];

        if ($darkMode === 'true') {
            setcookie('darkMode', 'true', time() + 60, "/");
        } else {
            setcookie('darkMode', '', time() - 3600, "/");
        }
    }

    if (isset($_POST['rainbowMode'])) {
        $rainbowMode = $_POST['rainbowMode'];

        if ($rainbowMode === 'true') {
            setcookie('rainbowMode', 'true', time() + 60, "/");
        } else {
            setcookie('rainbowMode', '', time() - 3600, "/");
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] === 'true') {
    $style .= '<link rel="stylesheet" type="text/css" href="stylesheets/darkmode.css">';
    $background = 'body {
        background: no-repeat fixed url("https://i.pinimg.com/originals/b8/dd/fb/b8ddfbb198825156089392b60b25b1ab.jpg");
    }';
} else {
    $style .= '<link rel="stylesheet" type="text/css" href="stylesheets/mainsheet.css">';
    $background = 'body {
        background: no-repeat fixed url("https://www.bhmpics.com/downloads/orange-marble-wallpaper/24.abstract-marble-texture-pattern-marble-texture-background-beautiful-orange-patterns-seen-from_131301-659.jpg");
    }';
}

if (isset($_COOKIE["rainbowMode"]) && $_COOKIE["rainbowMode"] === 'true') {
    $style .= '<link rel="stylesheet" type="text/css" href="stylesheets/rainbowmode.css">';
    $background = 'body {
        background: no-repeat fixed url("https://www.creativefabrica.com/wp-content/uploads/2020/06/17/Rainbow-Marble-Metallic-Ombre-Gradient-Graphics-4387862-1.png");
    }';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Athens, Greece, city, information">
    <meta name="description" content="This is a site about Athens, a city in Greece. It contains useful information.">
    <link rel="icon" type="image/x-icon" href="https://cdn3.iconfinder.com/data/icons/vol-2/128/column-512.png">
    <?php echo $style ?>
    <style><?php echo $background?></style>
    <script src="backend/keyevents.js" defer></script>
    <title>Athens – everything you need to know</title>
</head>

<body>
    <header id="header">
        <div id="mainphoto">
            <img src="https://www.national-geographic.pl/media/cache/big/uploads/media/default/0014/53/ateny-kolebka-cywilizacji-i-demokracji-co-warto-zobaczyc-w-stolicy-grecji.jpeg"
                alt="A picture of the city of Athens">
            <div>
                <section>
                    <h1 class>Welcome to <i>Athens</i>! - the city of your dreams</h1>
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
                </section>
                <h4 class>
                    &quot;A great city, whose image dwells in the memory of man, is the type of some great idea. Rome
                    represents conquest; Faith hovers over the towers of Jerusalem; and Athens embodies the pre-eminent
                    quality of the antique world, Art.&quot; - Benjamin Disraeli
                </h4>
    </header>
    <div style="margin: 20px;">
    <form method="post">
        <label>
            <input type="checkbox" name="darkMode" value="true" <?= isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'checked' : ''; ?>>
            Toggle Dark Mode
            <label>
            <input type="checkbox" name="rainbowMode" value="true" <?= isset($_COOKIE['rainbowMode']) && $_COOKIE['rainbowMode'] === 'true' ? 'checked' : ''; ?>>
            Toggle Rainbow Mode
        </label>
        </label>
    </form>
    <a href="diagnostics.php">Click here to check cookies</a>
</div>
    <main class="border-container">
        <article>
            <p>On this website you can find out <u>everything</u> about Athens and also test your knowledge with a <a
                    href="quiz_questions.html"><i>quiz</i></a>!</p>
            <img id="map" src="https://athensmap360.com/img/1200/athens-attractions-map.jpg"
                alt="A tourist map for Athens">
            <p>&gt;&gt;&gt; Click <a href="photos.zip">here</a> to download a zip file with beautiful photos of Athens
                in full size! &lt;&lt;&lt;</p>
            <p><mark>Press the right or left arrow on your keyboard to view the next photo!</mark></p>
            <p>Press <mark>Shift</mark> and hover over the image to zoom in the photo!</p>    
             <img  id="image" class="zoomable" src="images/athens1.png"
                alt="Small picture of Athens">
            <p>Press <mark>Alt</mark> and left-click on your mouse to draw on the canvas below!</p>
            <canvas id="drawingCanvas" width="800" height="600"></canvas>
            <p>Press <mark>Ctrl</mark> to show X and Y coordinates of your pointer position!</p>
            <div id="coordinates"></div>  
            <button id="dataButton">Statistics</button>
            <p id="statisticsInfo"></p>   
        </article>
    </main>
    <br>
    <footer class="semitransparent">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>

    <script src="backend/functions.js"></script>
    <script>
        let currentImageIndex = 0;

        window.addEventListener('keydown', (event) => {
            if (event.defaultPrevented) {
                return;
            }

            switch (event.key) {
                case 'ArrowLeft':
                    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                    showImage(currentImageIndex);
                    break;
                case 'ArrowRight':
                    currentImageIndex = (currentImageIndex + 1) % images.length;
                    showImage(currentImageIndex);
                    break;
                case 'ArrowDown':
                    document.scrollBy({ top: 100, behavior: 'smooth' });
                    break;
                case 'ArrowUp':
                    document.scrollBy({ top: -100, behavior: 'smooth' });
                    break;
                default:
                    break;
            }
            event.preventDefault();
        }, true);

        showImage(currentImageIndex);
    </script>
    <script src="backend/collectionevents.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const darkModeToggle = document.querySelector('input[name="darkMode"]');
            const rainbowModeToggle = document.querySelector('input[name="rainbowMode"]');

            darkModeToggle.addEventListener('change', function () {
                const darkModeForm = document.querySelector('form');

                if (darkModeToggle.checked) {
                    rainbowModeToggle.checked = false; // Ensure only one checkbox is checked
                    document.cookie = 'rainbowMode=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    darkModeForm.submit();
                } else {
                    // If unchecked, remove the cookie
                    document.cookie = 'darkMode=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    darkModeForm.submit();
                }
            });

            rainbowModeToggle.addEventListener('change', function () {
                const rainbowModeForm = document.querySelector('form');

                if (rainbowModeToggle.checked) {
                    darkModeToggle.checked = false; // Ensure only one checkbox is checked
                    document.cookie = 'darkMode=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    rainbowModeForm.submit();
                } else {
                    // If unchecked, remove the cookie
                    document.cookie = 'rainbowMode=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    rainbowModeForm.submit();
                }
            });
        });
    </script>



</body>

</html>