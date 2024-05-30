<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $risposta_sicurezza = sha1($_POST['risposta_sicurezza']); // Usa sha1 per confrontare

    // Verifica la risposta di sicurezza
    $sql = "SELECT risposta_sicurezza FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($risposta_sicurezza == $row['risposta_sicurezza']) {
            $stmt->close();
            $conn->close();
            // Reindirizza alla pagina di reimpostazione della password
            header("Location: reimposta_password.php?username=" . urlencode($username));
            exit();
        } else {
            $stmt->close();
            $conn->close();
            header("Location: recupera_password.php?error=Risposta errata.");
            exit();
        }
    } else {
        $stmt->close();
        $conn->close();
        header("Location: recupera_password.php?error=Utente non trovato.");
        exit();
    }
}
?>