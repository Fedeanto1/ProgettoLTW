<?php
include 'db_connect.php';
$uploadDir = 'uploads/'; 
foreach ($_FILES['images']['name'] as $key => $name) {
    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['images']['tmp_name'][$key];
        $filename = basename($name);
        $destPath = $uploadDir . $filename;
        if (move_uploaded_file($tmpName, $destPath)) {
            echo "File $filename caricato con successo.\n";
        } else {
            echo "Errore nel caricamento di $filename.\n";
        }
    } else {
        echo "Errore nel caricamento di $filename: " . $_FILES['images']['error'][$key] . "\n";
    }
}
?>
