<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: accedi.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['new_username'];
    $current_username = $_SESSION['username'];

    // Controlla se il nuovo username è già in uso
    $sql = "SELECT username FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['username_error'] = "Errore nella preparazione della query: " . $conn->error;
        header("Location: modifica_profilo.php");
        exit();
    }
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['username_error'] = "Username già in uso.";
        header("Location: modifica_profilo.php");
        exit();
    }

    // Aggiorna l'username nel database
    $update_sql = "UPDATE utenti SET username = ? WHERE username = ?";
    $stmt = $conn->prepare($update_sql);
    if ($stmt === false) {
        $_SESSION['username_error'] = "Errore nella preparazione della query di aggiornamento: " . $conn->error;
        header("Location: modifica_profilo.php");
        exit();
    }
    $stmt->bind_param("ss", $new_username, $current_username);

    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username; // Aggiorna la sessione con il nuovo username
        $_SESSION['username_success'] = "Username cambiato con successo.";
        header("Location: modifica_profilo.php");
        exit();
    } else {
        $_SESSION['username_error'] = "Errore durante il cambio dell'username: " . $stmt->error;
        header("Location: modifica_profilo.php");
        exit();
    }

    $stmt->close();
}
$conn->close();
?>