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

// Abfrage, um alle Genres abzurufen
$genre_sql = "SELECT * FROM genres";
$genre_result = $conn->query($genre_sql);
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
        <a href="?mainpage">
            <img src="Bilder/home_icon.png" class="nav-icon">
            Hauptseite
            </a>
            <a href="?library">
                <img src="Bilder/library_icon.png" class="nav-icon">
                Meine Liste
            </a>
            <a href="#">
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


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
    <label for="genre">Genre auswählen:</label>
    <select name="genre_id" id="genre">
        <?php
        if ($genre_result->num_rows > 0) {
            while ($row = $genre_result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['genre'] . "</option>";
            }
        } else {
            echo "<option value=''>Keine Genres gefunden</option>";
        }
        ?>
    </select>
    <input type="submit" value="Anzeigen">
    </form>
    
    
<?php
    // Wenn ein Genre ausgewählt wurde, zeige die Filme dieses Genres an
    if (isset($_GET['genre_id'])) {
        $genre_id = intval($_GET['genre_id']);

        // Abfrage, um alle Filme für das angegebene Genre abzurufen
        $sql = "SELECT movies.title, movies.erscheinungsjahr, movies.link, movies.dauer
                FROM movies 
                INNER JOIN genres ON movies.genre = genres.id
                WHERE genres.id = $genre_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Ausgabe der Filme
            echo "<h2> Movies </h2>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Titel</th>";
            echo "<th>Erscheinungsjahr</th>";
            echo "<th>Dauer</th>";
            echo "<th>IMDb-Link</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["erscheinungsjahr"] . "</td>";
                echo "<td>" .$row["dauer"] . "</td>";
                echo "<td><a href='" . $row["link"] . "'>" . $row["link"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Keine Filme für dieses Genre gefunden.";
        }

        // Abfrage, um alle Filme für das angegebene Genre abzurufen
        $sql = "SELECT serien.title, serien.erscheinungsjahr, serien.link, serien.staffeln
                FROM serien 
                INNER JOIN genres ON serien.genre = genres.id
                WHERE genres.id = $genre_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Ausgabe der Filme
            echo "<h2> Serien </h2>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Titel</th>";
            echo "<th>Erscheinungsjahr</th>";
            echo "<th>Staffelnanzah</th>";
            echo "<th>IMDb-Link</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["erscheinungsjahr"] . "</td>";
                echo "<td>" .$row["staffeln"] . "</td>";
                echo "<td><a href='" . $row["link"] . "'>" . $row["link"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Keine Serien für dieses Genre gefunden.";
        }
    }

    // Verbindung schließen
    $conn->close();
?>

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
