<?php
// include 'variables.php';

session_start();
// Überprüfen, ob der Benutzer eingeloggt ist
if (in_array("loggedin", $_SESSION) == false)
{
    echo "Sie sind nicht eingeloggt, weil keine Session da ist";
    exit;
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Benutzer ist nicht eingeloggt, Beende die Session und zeige eine Fehlermeldung
    session_unset(); // Alle Session-Variablen löschen
    session_destroy(); // Session zerstören
    echo "Fehler: Sie sind nicht eingeloggt.";
    exit;
}


if(isset($_GET['logout'])) {
    // Session beenden
    session_unset(); // Alle Session-Variablen löschen
    session_destroy(); // Session zerstören

    // Weiterleitung zur Anmeldeseite
    header("Location: index.php");
    exit;
}

if(isset($_GET['library'])) {

    header("Location: library.php");
    exit;
}

if(isset($_GET['mainpage'])) {

    header("Location: mainpage.php");
    exit;
}

if(isset($_GET['genres'])) {

    header("Location: genres.php");
    exit;
}

if(isset($_GET['addmovie'])) {

    header("Location: add.php");
    exit;
}

if(isset($_GET['addseries'])) {

    header("Location: addseries.php");
    exit;
}

// Verbindung zur Datenbank erstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "steamdb";
// Stelle sicher, dass das Formular gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüfe, ob alle erforderlichen Felder ausgefüllt sind
    if (isset($_POST["title"]) && isset($_POST["erscheinungsjahr"]) && isset($_POST["genre"]) && isset($_POST["dauer"]) && isset($_POST["imdb_link"])) {
        // Verbinde dich mit der Datenbank (hier gehst du davon aus, dass du bereits eine Verbindung hast)

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }

        // Bereite die Werte für die Einfügung in die Datenbank vor (verhindere SQL-Injection)
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $erscheinungsjahr = intval($_POST["erscheinungsjahr"]); // Stelle sicher, dass es sich um eine ganze Zahl handelt
        $genre_id = intval($_POST["genre"]); // Genre-ID aus dem Formular
        $dauer = intval($_POST["dauer"]); // Stelle sicher, dass es sich um eine ganze Zahl handelt
        $imdb_link = mysqli_real_escape_string($conn, $_POST["imdb_link"]);

        // Füge den Film zur Datenbank hinzu
        $sql = "INSERT INTO movies (title, erscheinungsjahr, genre, dauer, link) VALUES ('$title', $erscheinungsjahr, 1,$dauer, '$imdb_link')";

        if ($conn->query($sql) === TRUE) {
            // Film erfolgreich hinzugefügt, jetzt fügen wir die Verknüpfung zwischen Film und Genre hinzu
            $last_movie_id = $conn->insert_id; // ID des zuletzt eingefügten Films abrufen

            // Füge die Verknüpfung in die Tabelle movie_genres ein
            $update_sql = "UPDATE movies SET genre = $genre_id WHERE id = $last_movie_id";
            if ($conn->query($update_sql) === TRUE) {
                echo "Film erfolgreich zur Datenbank hinzugefügt.";
                $user_email = $_SESSION["email"];
                $favorite_sql = "INSERT INTO user_movies (email, movie) VALUES ('$user_email', $last_movie_id)";
                if ($conn->query($favorite_sql) === TRUE) {
                    echo "Film wurde zur Favoritenliste hinzugefügt.";
                }
            } else {
                echo "Fehler beim Hinzufügen des Films: " . $conn->error;
            }
        } else {
            echo "Fehler beim Hinzufügen des Films: " . $conn->error;
        }

        // Schließe die Verbindung zur Datenbank
        $conn->close();
    } else {
        echo "Bitte füllen Sie alle erforderlichen Felder aus.";
    }
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>SteamDB</title>
    <style>
        /* CSS-Regeln für die Seite */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Die Mindesthöhe des Body-Elements entspricht der Höhe des Viewports */
        }

        main {
            flex: 1; /* Der Hauptinhalt dehnt sich aus, um den verfügbaren Platz zwischen dem Header und dem Footer auszufüllen */
        }

        footer {
            text-align: center; /* Zentriere den Text im Footer */
            padding: 20px; /* Füge einen Innenabstand hinzu */
            margin-top: auto; /* Setze den oberen Außenabstand auf "auto", um den Footer an den unteren Rand der Seite zu drücken */
        }
    </style>
</head>
<body>
      <!-- Logo oben rechts -->
    <div id="logo-container">
        <img id="logo" src="Bilder/logo.png" alt="logo">
    </div>
    <span onclick="openNav()">&#9776;</span>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="?mainpage">
            <img src="Bilder/home_icon.png" class="nav-icon">
            Hauptseite
            </a>
            <a href="?library">
                <img src="Bilder/library_icon.png" class="nav-icon">
                Meine Liste
            </a>
            <a href="?genres">
                <img src="Bilder/genres_icon.png" class="nav-icon">
                Genres
            </a>
            <button class="dropdown-btn" style="padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 20px;
                color: #818181;
                display: block;
                border: none;
                background: none;
                width:100%;
                text-align: left;
                cursor: pointer;
                outline: none;">
                    <img src="Bilder/add_icon.png" class="nav-icon">
                    Add
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="#">Add Movie</a>
                <a href="?addseries">Add Series</a>
            </div>
            <a href="?logout">
                <img src="Bilder/logout_icon.png" class="nav-icon">
                Abmelden
        </a>
        </div>
    <form action="add.php" method="POST">
    <label for="title">Titel des Films:</label>
    <input type="text" id="title" name="title" required><br><br>
    
    <label for="erscheinungsjahr">Erscheinungsjahr:</label>
    <input type="number" id="erscheinungsjahr" name="erscheinungsjahr" required><br><br>
    
    <div class="form-group">
        <label for="genre">Genre:</label>

    <?php
    // Verbindung zur Datenbank erstellen
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "steamdb";
        // Abfrage, um alle Genres aus der Tabelle "Genres" abzurufen
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }
        $genres_sql = "SELECT * FROM genres";
        $genres_result = $conn->query($genres_sql);

        if ($genres_result->num_rows > 0) {
            echo "<select name='genre'>";
            // Schleife durch jedes Ergebnis und füge eine Option im Dropdown-Menü hinzu
            while ($row = $genres_result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['genre'] . "</option>";
            }
            echo "</select>";
        } else {
            echo "<option value=''>Keine Genres gefunden</option>";
        }
    ?>
  </div>
    
  <br>
  
    <div class="form-group">
        <label for="dauer">Dauer des Films (in Minuten):</label><br>
        <input type="number" id="dauer" name="dauer" required><br><br>
    </div>
    
    <label for="imdb_link">IMDb-Link:</label>
    <input type="url" id="imdb_link" name="imdb_link"><br><br>
    
    <input type="submit" value="Film hinzufügen">
</form>

    <footer>
        <p id="Authors">Authors: Mohammad Freej <br> Dario Kasumovic Carballeira <br> Mohammad Jalal Mobasher Goljani <br> Katherina Nolte</p>
        <p id="Mail"><a href="mailto:hege@example.com">dario.carballeira98@web.de</a></p>
    </footer>
    <script>
        function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        }
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
            } else {
            dropdownContent.style.display = "block";
            }
        });
        }
    </script>
</body>
</html>
