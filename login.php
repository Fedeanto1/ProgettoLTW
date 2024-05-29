<?php
    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<pre>"; print_r($_POST); echo "</pre>";
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        $password_hash = sha1($password);

        $sql = "SELECT id, username, password_hash FROM utenti WHERE email = ? AND password_hash=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password_hash);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $utente = $result->fetch_assoc();
            print_r($password);
            print_r($utente['password_hash']);
            if ($password_hash == $utente['password_hash']) {
                // Password corretta, inizia la sessione
                $_SESSION['userid'] = $utente['id'];
                $_SESSION['username'] = $utente['username'];
                echo "Login effettuato con successo! Benvenuto, " . $utente['username'] . ".";
                // Redirect verso una pagina protetta
                header("Location: HomePage.php");
                exit();
            } else {
                header("Location: accedi.php?error=Credenziali non valide");
            }
        } else {
            header("Location: accedi.php?error=Credenziali non valide");
        }
        $stmt->close();
    }
    $conn->close();
?>

