<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <lang="de">
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

<?php

// Variablen für die Datenbankverbindung erstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "steamdb";

// Verbindung zur Datenbank erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

$email = $passwort = $hashed_password = "";

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
        echo $email_err;
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if passwort is empty
    if (empty(trim($_POST["passwort"]))) {
        $password_err = "Please enter your passwort.";
        echo $password_err;
    } else {
        $passwort = trim($_POST["passwort"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT email, passwort FROM usrs WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                echo $stmt->num_rows;
                // Check if email exists, if yes then verify passwort
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($email, $hashed_password);
                    echo $hashed_password;
                    if ($stmt->fetch()) {
                        if ($passwort == $hashed_password) {
                            // Password is correct, so start a new session
                            include 'variables.php';
                            $loginstat = true;
                            session_start();
                            $_SESSION["email"] = $email;
                            $_SESSION["loggedin"] = true;
                            // Redirect user to welcome page
                            echo "login success";
                            header("Location: mainpage.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or passwort.";
                            echo $login_err;
                        }
                    }
                } else {
                    // email doesn't exist, display a generic error message
                    $login_err = "Invalid cd jsck email or passwort.";
                    echo $login_err;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo $login_err;
            }

            // Close statement
                }

    }

}



?>

<a href="index.php"><img src="bilder/logo.png" alt="logo" id="logo"></a>
<form action="index.php" method="POST">
    Mail: <input type="text" name="email" required><br><br>
    Passwort: <input type="passwort" name="passwort" required><br><br>
    <input type="submit" id="submit" value="Anmelden"><br><br>
</form>
<form action="users.php" method="GET">
    <input type="submit" style="width: 101%; height: 40px; background: transparent; border-color: transparent; color: blueviolet; font-size: 20px;" value="Registrieren">
</form>
<footer>
    <p id="Authors">Authors: Mohammad Freej <br> Dario Kasumovic Carballeira <br> Mohammad Jalal Mobasher Goljani <br> Katherina Nolte</p>
    <p id="Mail"><a href="mailto:hege@example.com">hege@example.com</a></p>
</footer>
</body>
</html>
