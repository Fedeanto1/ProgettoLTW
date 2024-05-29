<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: accedi.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new password and confirmation match
    if ($new_password !== $confirm_password) {
        $_SESSION['password_error'] = "Le nuove password non corrispondono.";
        header("Location: modifica_profilo.php");
        exit();
    }

    // Retrieve the user's current password from the database
    $sql = "SELECT password_hash FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['password_error'] = "Errore nella preparazione della query: " . $conn->error;
        header("Location: modifica_profilo.php");
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 0) {
        $_SESSION['password_error'] = "Utente non trovato.";
        header("Location: modifica_profilo.php");
        exit();
    }

    $row = $result->fetch_assoc();
    $password_from_db = $row['password_hash'];

    // Check if the old password is correct
    if (sha1($old_password) !== $password_from_db) {
        $_SESSION['password_error'] = "La vecchia password non è corretta.";
        header("Location: modifica_profilo.php");
        exit();
    }

    // Update the password in the database
    $new_password_hash = sha1($new_password);
    $update_sql = "UPDATE utenti SET password_hash = ? WHERE username = ?";
    $stmt = $conn->prepare($update_sql);
    if ($stmt === false) {
        $_SESSION['password_error'] = "Errore nella preparazione della query di aggiornamento: " . $conn->error;
        header("Location: modifica_profilo.php");
        exit();
    }
    $stmt->bind_param("ss", $new_password_hash, $username);

    // Execute the update statement
    if ($stmt->execute()) {
        $_SESSION['password_success'] = "Password cambiata con successo.";
        header("Location: modifica_profilo.php");
        exit();
    } else {
        $_SESSION['password_error'] = "Errore durante il cambio della password: " . $stmt->error;
        header("Location: modifica_profilo.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>