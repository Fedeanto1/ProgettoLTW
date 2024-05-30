<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>"; print_r($_POST); echo "</pre>";
    $username = $conn->real_escape_string($_POST['username']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $cognome = $conn->real_escape_string($_POST['cognome']);
    $email = $conn->real_escape_string($_POST['email']);
    $password_hash = sha1($_POST['password']);
    $domanda_sicurezza = $conn->real_escape_string($_POST['domanda_sicurezza']);
    $risposta_sicurezza = sha1($_POST['risposta_sicurezza']); // Usa sha1 invece di password_hash

    $sql = "SELECT id FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header("Location: registrati.php?error=Username già utilizzato.");
        $stmt->close();
    } else {
        $stmt->close();
        $sql = "SELECT id FROM utenti WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            header("Location: registrati.php?error=Email già utilizzata.");
            $stmt->close();
            $conn->close();
        } else {
            $stmt->close();
            // Inserimento dati nel database
            $sql = "INSERT INTO utenti (username, nome, cognome, email, password_hash, domanda_sicurezza, risposta_sicurezza) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $username, $nome, $cognome, $email, $password_hash, $domanda_sicurezza, $risposta_sicurezza);
            if ($stmt->execute()) {
                header("Location: accedi.php");
                $stmt->close();
            } else {
                echo "Errore: " . $stmt->error;
                $stmt->close();
            }
        }
    }
}
$conn->close();
?>
