<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_viaggio = $_POST['id_viaggio'];

    $query = "DELETE FROM viaggio WHERE id_viaggio = $id_viaggio";

    if (mysqli_query($conn, $query)) {
        header("Location: MieiViaggi.php");
        exit();
    } else {
        echo "Errore nell'eliminazione del record: " . mysqli_error($conn);
    }
}

$conn->close();
?>