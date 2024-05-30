<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $new_password = sha1($_POST['new_password']); // Usa sha1 per hashare la nuova password
    $confirm_password = sha1($_POST['confirm_password']); // Usa sha1 per confrontare

    if ($new_password !== $confirm_password) {
        header("Location: reimposta_password.php?username=$username&error=Le password non coincidono.");
        exit();
    }

    // Aggiorna la password nel database
    $sql = "UPDATE utenti SET password_hash = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $username);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: accedi.php?success=Password reimpostata con successo.");
        exit();
    } else {
        // Mostra l'errore nel caso di fallimento
        echo "Errore durante l'aggiornamento della password: " . $stmt->error;
        $stmt->close();
        $conn->close();
    }
}
?>