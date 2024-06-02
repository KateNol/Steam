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

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>SteamDB</title>
</head>
<body>
    <!-- Logo oben rechts -->
    <div id="logo-container">
        <img id="logo" src="Bilder/logo.png" alt="logo">
    </div>
    <span onclick="openNav()">&#9776;</span>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">
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
                <a href="?addmovie">Add Movie</a>
                <a href="?addseries">Add Series</a>
            </div>
            <a href="?logout">
                <img src="Bilder/logout_icon.png" class="nav-icon">
                Abmelden
        </a>
        </div>
    <h1 id="welcome-message">Willkommen auf der Hauptseite!</h1>
    </div>

    <footer>
        <p id="Authors">Authors: Mohammad Freej <br> Dario Kasumovic Carballeira <br> Mohammad Jalal Mobasher Goljani <br> Katharina Nolte</p>
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
