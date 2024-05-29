<?php
include 'db_connect.php';/*
$viaggio=$_POST['viaggio'];
$utente=$_POST['utente'];
$viaggio = mysqli_real_escape_string($conn, $viaggio);
$utente = mysqli_real_escape_string($conn, $utente);

$query = "SELECT * FROM preferiti WHERE viaggio = ? AND utente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $viaggio, $utente);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result)>0){
    $stmt = $conn->prepare("DELETE FROM preferiti WHERE viaggio=? AND utente=?");
    $stmt->bind_param("ii", $viaggio, $utente);

    if ($stmt->execute()) {
        echo "Favorite removed successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
} else{
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO preferiti (viaggio, utente) VALUES (?, ?)");
    $stmt->bind_param("ii", $viaggio, $utente);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Favorite added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();*/

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: accedi.php");
    exit();
}

$userId = $_SESSION['userid'];
$viaggioId = $_POST['viaggio'];

$query = "SELECT * FROM preferiti WHERE utente = ? AND viaggio= ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $viaggioId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Se esiste già, rimuovilo
    $query = "DELETE FROM preferiti WHERE utente = ? AND viaggio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $viaggioId);
} else {
    // Se non esiste, aggiungilo
    $query = "INSERT INTO preferiti (utente, viaggio) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $viaggioId);
}

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>