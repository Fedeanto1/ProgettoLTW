<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>"; print_r($_POST); echo "</pre>";
    $username = $conn->real_escape_string($_POST['username']);
    $nome=$conn->real_escape_string($_POST['nome']);
    $cognome=$conn->real_escape_string($_POST['cognome']);
    $email = $conn->real_escape_string($_POST['email']);
    $password_hash = sha1($_POST['password']);

    $sql = "SELECT id FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header("Location: registrati.php?error=Username già utilizzato.");
        $stmt->close();
    } else{
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
        } else{
            $stmt->close();
            // Inserimento dati nel database
            $sql = "INSERT INTO utenti (username, nome, cognome, email, password_hash) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss",$username, $nome, $cognome, $email, $password_hash);
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
