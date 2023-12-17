<?php
session_start();

if (isset($_SESSION['created']) && (time() - $_SESSION['created'] > $_SESSION['lifetime'])) {
    session_unset();
    session_destroy();
}

$style='';
$background='';
if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] === 'true') {
    $style = '<link rel="stylesheet" type="text/css" href="stylesheets/darkmode.css">';
    $background = '
    body {
    background-image: url("https://www.shutterstock.com/image-vector/hand-drawn-simple-abstract-flowers-600nw-2323137643.jpg");
    background-repeat: repeat;
    }';
}
else if (isset($_COOKIE["rainbowMode"]) && $_COOKIE["rainbowMode"] === 'true'){
    $style = '<link rel="stylesheet" type="text/css" href="stylesheets/rainbowmode.css">';
    $background = '
    body {
    background-image: url("https://img.freepik.com/premium-vector/fabulous-cartoon-dark-olive-branches-shine-elements-vector-seamless-pattern_647116-153.jpg");
    background-repeat: repeat;
    }';
}
else {
    $style = '<link rel="stylesheet" type="text/css" href="stylesheets/mainsheet.css">';
    $background = '
    body {
    background-image: url("https://media.istockphoto.com/id/1249866274/vector/olive-branch-seamless-pattern.jpg?s=612x612&w=0&k=20&c=_rdjry6inYvdS_b0LzJla9NxM1OC3q2KcVTMHiTGu8c=");
    background-repeat: repeat;
}';
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Athens, Greece, city, information, famous people, landmarks, places">
    <meta name="description" content="On this website you can find out about famous places in Athens and people.">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/6406/6406590.png">
    <?php echo $style; ?>
    <script src="backend/keyevents.js" defer></script>
    <script src="backend/collectionevents.js" defer></script>
    <title>Famous Places and People in Athens</title>
    <style>
       <?php echo $background?>
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

    <main>
        <section id="places-list" class="semitransparent">
            <h1>Famous places in Athens</h1>
            <p>There are a lot of beautiful and outstanding landmarks in Athens that you absolutely <b>need</b> to visit
                if you have the chance!</p>

            <ol type="I">
                <li><a href="#Parthenon" name="Parhenon">Parthenon</a></li>
                <li><a href="#Acropolis_Museum" name="Acropolis_Musuem">Acropolis Museum</a></li>
                <li><a href="#Library">Hadrian's Library</a></li>
                <li><a href="#Stadium">Panathenaic Stadium</a></li>
                <li><a href="#Cemetery">First Cemetery of Athens</a></li>
                <li><a href="#Syntagma_Square">Syntagma Square</a></li>
                <li>Temples
                    <ol type="a">
                        <li><a href="#Hephaestus_Temple">Temple of Hephaestus</a></li>
                        <li><a href="#Athena_Temple">Temple of Athena Nike</a></li>
                        <li><a href="#Zeus_Temple">Temple of Olympian Zeus</a></li>
                        <li><a href="#Poseidon_Temple">Temple of Poseidon</a></li>
                    </ol>
                </li>
                <li><a href="#Tomb">Tomb of the Unknown Soldier</a></li>
            </ol>
            <p>Source: <a
                    href="https://www.destguides.com/greece/attica/athens/famous-landmarks-athens">https://www.destguides.com/greece/attica/athens/famous-landmarks-athens</a>
            </p>
        </section>

        <section id="athenians-list" class="semitransparent">
            <h1>Famous Athenians</h1>
            <ul>
                <li>Solon</li>
                <li>Cleithenes</li>
                <li>Plato</li>
                <li>Pericles</li>
                <li>Socrates</li>
                <li>Peisistratos</li>
                <li>Thucydides</li>
                <li>Themistocles</li>
                <li>Isocrates</li>
            </ul>
            <br>
            <input type="text" id="insert-athenian" placeholder="Athenian to insert">
            <input type="number" id="insert-index" placeholder="Index to insert at">
            <button id="button-insert" class="element-button">Insert</button>
            <br>
            <input type="text" id="replace-athenian" placeholder="Athenian to replace with">
            <input type="number" id="replace-index" placeholder="Index to replace">
            <button id="button-replace" class="element-button">Replace</button>
            <br>
            <input type="number" id="remove-index" placeholder="Index to remove">
            <button id="button-remove" class="element-button">Remove</button>

            <!-- <button id="button-remove" class="element-button">Remove first Athenian</button>
            <button id="button-add-removed" class="element-button">Add most recently removed Athenian as last</button>
            <br>
            <button id="button-insert" class="element-button">Insert Alcibiades before last Athenian</button>
            <br>
            <button id="button-replace-1" class="element-button">Replace 5th Athenian with Sophocles</button>
            <button id="button-replace-2" class="element-button">Move most recently replaced Athenian to last</button>
            <br>
            <button id="button-remove-section" class="element-button">Remove entire 'Athenians' section</button>
            <br><br> -->
            <p> Source: <a
                    href="https://greecetravelideas.com/famous-athenians/">https://greecetravelideas.com/famous-athenians/</a>
            </p>
        </section>

        <article>
            <div class="article">
                <h2 id="Parthenon">Parthenon</h2>
                <div class="image-container">
                    <img src="https://cdn.britannica.com/54/150954-050-F8D14782/Night-view-Parthenon-Athens.jpg" name ="Parthenon" class="zoomable"
                        alt="Parthenon photo" style="width:600px;height:400px;" >
                </div>
                <p>The Parthenon is the iconic temple ruins that sit at the very top of the Acropolis of Athens.
                    Construction of the original temple began in 447 BC, and it stood as the emblem of ancient Greece.
                    Up close, this is a visually stunning European landmark. If you look closely, you can see tiny
                    sculptures and other flairs that make ancient Greek architecture so impressive.</p>
                <details>
                    <summary>How it was created</summary>
                    <p>Construction started in 447 BC when the Delian League was at the peak of its power. It was
                        completed in 438 BC; work on the decoration continued until 432 BC. For a time, it served as the
                        treasury of the Delian League, which later became the Athenian Empire. In the final decade of
                        the 6th century AD, the Parthenon was converted into a Christian church dedicated to the Virgin
                        Mary. After the Ottoman conquest in the mid-fifteenth century, it became a mosque. In the Morean
                        War, a Venetian bomb landed on the Parthenon, which the Ottomans had used as a munitions dump,
                        during the 1687 siege of the Acropolis. The resulting explosion severely damaged the Parthenon.
                        From 1800 to 1803, the 7th Earl of Elgin took down some of the surviving sculptures, now known
                        as the Elgin Marbles, in an act widely considered, both in its time and subsequently, to
                        constitute vandalism and looting.

                        The Parthenon replaced an older temple of Athena, which historians call the Pre-Parthenon or
                        Older Parthenon, that was demolished in the Persian invasion of 480 BC.

                        Since 1975, numerous large-scale restoration projects have been undertaken to preserve remaining
                        artifacts and ensure its structural integrity.</p>
                </details>
            </div>
            <article>
                <div class="article">
                    <h2 id="Acropolis_Museum">Acropolis Museum</h2>
                    <p>The Acropolis Museum is consistently rated as one of the <mark>best museums in the world</mark>.
                        Devoted to the Parthenon and its surrounding temples, it is cleverly perched above Athens like a
                        luminous box. The large glass panes beautifully draw in the ancient and modern parts of the
                        city, making it a truly evocative experience. Designed by New York’s, Bernard Tschumi, with
                        local Greek architect Michael Photiadis, it is the perfect sanctuary for the ancient artefacts
                        that were found in and around the Acropolis and successfully deconstructs how the Parthenon
                        sculptures once looked to the citizens of ancient Athens.</p>
                    <p>Located in the central neighbourhood of Makrigianni, the museum is framed by olive trees and
                        propped up by concrete pillars, revealing the site’s archaeological excavation below. The
                        remnants are of an ancient neighbourhood that once thrived, complete with a drainage system,
                        bathhouses and mosaics.</p>
                    <details>
                        <summary>History</summary>
                        <p>The first museum was on the Acropolis; it was completed in 1874 and underwent a moderate
                            expansion in the 1950s. However, successive excavations on the Acropolis uncovered many new
                            artifacts which significantly exceeded its original capacity.
                            An additional motivation for the construction of a new museum was that in the past, when
                            Greece made requests for the return of the Parthenon Marbles from the United Kingdom, which
                            acquired the items in a controversial manner, it was suggested by some British officials
                            that Greece had no suitable location where they could be displayed. Creation of a gallery
                            for the display of the Parthenon Marbles has been key to all recent proposals for the design
                            of a new museum.</p>
                    </details>
                    <aside>
                        <h3>Location</h3>
                        <p>The museum is located by the southeastern slope of the Acropolis hill, on the ancient road
                            that led up to the "sacred rock" in classical times. Set only 280 meters (310 yd), away from
                            the Parthenon, and a 400 meters (440 yd) walking distance from it, the museum is the largest
                            modern building erected so close to the ancient site, although many other buildings from the
                            last 150 years are located closer to the Acropolis. The entrance to the building is on
                            Dionysiou Areopagitou Street and directly adjacent to the Akropoli metro station the red
                            line of the Athens Metro.</p>
                    </aside>
                    <div class="image-container">
                        <a href="https://whyathens.com/the-acropolis-museum/" target="_blank"><img class="zoomable"
                                src="https://whyathens.com/wp-content/uploads/2016/10/Acropolis-Museum-Underfloor-Entrance-Why-Athens-1265x810.jpg"
                                alt="The remnants of an ancient city at the entrance of the museum. Photograph: Why Athens | Acropolis Museum"
                                style="width:1000px;height:600px;"></a>
                        <img src="https://whyathens.com/wp-content/uploads/2016/10/Acropolis-Museum-Floral-Acroterion-Parthenon-gallery-1-1440x798.jpg"
                            alt="A reconstruction from both original and plaster pieces of the floral ‘Akroterion’ which crowned the top of the east pediment measuring 4 metres high. Photograph: Why Athens | Acropolis Museum"
                            style="width:1000px;height:600px;"
                            class="zoomable">
                    </div>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Library">Hadrian's Library</h2>
                    <div class="image-container">
                        <img src="https://www.worldhistory.org/img/c/p/1200x627/4133.jpg"
                            alt="Hadrian's Library picture" class="zoomable">
                    </div>
                    <p>Hadrian's Library is one of the most famous monuments in Athens, Greece. Roman Emperor Hadrian
                        built it in 132 AD. Typical of its Roman architectural style, it originally had 100 columns
                        adorning the outside. As you wander around the structure, you can get a feel of how the Romans
                        lived.</p>
                    <p>The library was previously used to store rolls of Papyrus, the ancient Greek equivalent of books,
                        and hosting music and lecture rooms. Even though the building is not in great condition today,
                        it is still exciting to imagine how magnificent it would have been in Roman times. You can visit
                        this site for just €4, or it is included in the Acropolis combination ticket.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Stadium">Panathenaic Stadium</h2>
                    <div class="image-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/Panathenaic_Stadium_-_panoramio_%281%29.jpg"
                            alt="Panathenaic Stadium Photo" style="width:1000px;height:600px;" class="zoomable">
                    </div>
                    <p>Since Athens is the home of the modern Olympic games, it is only right that you visit the
                        Panathenaic Stadium. This is the only stadium in the world that is built completely from marble.
                        The stadium was originally built for ancient Greek athletics championships, where naked male
                        athletes competed against each other.</p>
                    <p>Most recently, the stadium was used for the 2004 Olympics hosted in Athens and was also the
                        location of the 2011 Special Olympics summer games. The stadium is also often converted into a
                        concert space – though it is worth visiting whether there is a concert on or not, as it is
                        unlike any other stadium that exists.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Cemetery">First Cemetery of Athens</h2>
                    <div class="image-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f0/The_First_Cemetery_of_Athens.jpg"
                            alt="First Cemetery of Athens" style="width:1000px;height:600px;" class="zoomable">
                    </div>
                    <p>As the name suggests, this is the first known cemetery to be built in the city in 1837. The
                        cemetery not only has some of the most famous Greeks buried here, like the poet Giorgos Seferis
                        and the infamous Odysseas Androutsos, but also acts as an open-air museum for visitors to
                        explore.</p>
                    <p>With romantic Neoclassical sculptures throughout the park, it is the perfect place to spend a
                        couple of hours if you are in the centre of the city and want a tranquil, albeit slightly eerie
                        walk, amongst some of the most remarkable people Greece has ever seen.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Syntagma_Square">Syntagma Square</h2>
                    <div class="image-container">
                        <img src="https://www.thestanley.gr/sites/thestanley/files/items/61.jpg" class="zoomable"
                            alt="Syntagma Square - Parliament building" style="width:600px;height:400px;">
                        <img src="https://media.tacdn.com/media/attractions-splice-spp-674x446/0b/27/5e/c4.jpg" class="zoomable"
                            alt="Syntagma Square city view" style="width:600px;height:400px;">
                    </div>
                    <p>Situated in the heart of Athens, Syntagma Square is the bustling hub of the city. The square is
                        overlooked by Greek Parliament, and you will often find people relaxing near the water fountain
                        in the square on a hot summer's day.</p>
                    <p>The square is located nearby to the popular Plaka and Monastiraki neighbourhoods, and so it is
                        the perfect starting point in the morning.
                        This really is the square of the people. Greeks often gather here, whether it is to celebrate or
                        to protest. No trip is complete without a wander through this iconic landmark in Athens.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Hephaestus_Temple">Temple of Hephaestus</h2>
                    <div class="image-container">
                        <img src="https://static.wixstatic.com/media/ea8ea8_77309d3be39142378b40b58d22013f2c~mv2.png/v1/fill/w_880,h_542,al_c,q_90/ea8ea8_77309d3be39142378b40b58d22013f2c~mv2.png"
                            alt="Temple of Hephaestus" style="width:800px;height:600px;" class="zoomable">
                    </div>
                    <p>This is another famous landmark that features in many iconic photographs. The Temple of
                        Hephaestus was designed by Iktinus in approximately 450BC, who also created the Parthenon and
                        other architectural feats around the city.</p>
                    <p>Whilst this temple has been damaged by numerous earthquakes and invasions, it is still one of the
                        best-preserved ancient temples in the whole of Greece.</p>
                    <p>You can see straight through the temple, and up close, you get the sense of how much the Greeks
                        loved to incorporate intricately designed columns and artistic touches on their buildings.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Athena_Temple">Temple of Athena Nike</h2>
                    <div class="image-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Temple_of_Athena_Nik%C3%A8_from_Propylaea%2C_Acropolis%2C_Athens%2C_Greece.jpg"
                            alt="Temple of Athena Nike" style="width:1000px;height:600px;" class="zoomable">
                    </div>
                    <p>Another temple located on the Acropolis of Athens is the landmark dedicated to Goddesses Athena
                        and Nike. This stunning temple was initially destroyed by the Turks in 1686, before being
                        rebuilt in 1834 after the Independence of Greece.</p>
                    <p>Though it is the smallest of the Acropolis structures, the Temple of Athena Nike holds just as
                        much historical importance to the city. Cultists previously used it to worship the Goddesses.
                    </p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Zeus_Temple">Temple of Olympian Zeus</h2>
                    <div class="image-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/L%27Olympieion_%28Ath%C3%A8nes%29_%2830776483926%29.jpg"
                            alt="Temple of Olympian Zeus" style="width:1000px;height:600px;" class="zoomable">
                    </div>
                    <p>Dedicated to perhaps one of the most famous Greek Gods, the Temple of Olympian Zeus sits at the
                        centre of Athens. Originally the temple was grand, with 104 giant columns adorning the
                        structure. Though most of them were destroyed in a barbaric attack in 267AD, leaving just 15
                        standing.</p>
                    <p>Today, the temple is an open-air museum that exhibits one of the most famous archaeological sites
                        in Greece. Its central location means that you have great views of the Acropolis and other
                        historical sites scattered across the city as you walk through the grounds.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Poseidon_Temple">Temple of Poseidon</h2>
                    <div class="image-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Greece_Cape_Sounion_BW_2017-10-09_10-12-43.jpg/1200px-Greece_Cape_Sounion_BW_2017-10-09_10-12-43.jpg"
                            alt="Temple of Poseidon" style="width:1000px;height:600px;" class="zoomable">
                    </div>
                    <p>The Temple of Poseidon sits in Sounion at the very southern coast of the Attica peninsula. This
                        is the archaeological site that is said to be where Aegeus, the King of Athens, fell into the
                        sea. As it is only an hour's drive from the centre of Athens, this is a famous landmark
                        well-worthy of a day trip from Athens.</p>
                    <p>The temple itself is colossal, with the majority of its columns still standing. There's a nearby
                        café where you can grab lunch, as well as steps down to a small but gorgeous beach.</p>
                </div>
            </article>
            <article>
                <div class="article">
                    <h2 id="Tomb">Tomb of the Unknown Soldier</h2>
                    <div class="image-container">
                        <img src="https://aktis.app/uploads/attractions/318md9qelveowos8wg.jpg"
                            alt="Tomb of the Unknown Soldier" style="width:500px;height:350px;" class="zoomable">
                    </div>
                    <p>The Tomb of the Unknown Soldier is the cenotaph dedicated to the Greek soldiers killed during
                        war. It is located in front of the parliament building and is famous for being guarded by the
                        Evzones of the Presidential Guard in their traditional outfits.</p>
                    <p>The tomb itself is made from beautiful limestone, with intricate details inscribed into the tomb.
                        Carved into the wall is a soldier wearing just a helmet and wielding a shield.</p>
                    <p>Locals and tourists alike gather in Syntagma Square every Sunday morning at 11 am to watch the
                        changing of the guards at this landmark. This is a wonderful experience to catch if you are in
                        the nearby area.</p>
                </div>
            </article>
    </main>
    <br>
    <section class="semitransparent">
        <button id="dataButton">Statistics</button>
        <p id="statisticsInfo"></p> 
    </section>
    <footer class="semitransparent">
        <a href="#header">Back to top</a>
        <p>Write to us: <a href="mailto:Athens_Greece@gmail.com">Athens_Greece@gmail.com</a></p>
    </footer>

    <script src="backend/elements.js"></script>
</body>

</html>