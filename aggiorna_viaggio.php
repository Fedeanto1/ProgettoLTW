<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_viaggio = $_POST['id_viaggio'];
    $partenza = mysqli_real_escape_string($conn, $_POST['partenza']);
    $destinazione = mysqli_real_escape_string($conn, $_POST['destinazione']);
    $andata = $_POST['andata'];
    $ritorno = $_POST['ritorno'];
    $alloggio = $_POST['alloggio'];
    $commento = mysqli_real_escape_string($conn, $_POST['commento']);

   
    $query = "UPDATE viaggio SET partenza='$partenza', destinazione='$destinazione', andata='$andata', ritorno='$ritorno', alloggio= '$alloggio', commento='$commento' WHERE id_viaggio=$id_viaggio";

    if (mysqli_query($conn, $query)) {
        for ($i = 1; $i <= 10; $i++) {
            $attrazione = mysqli_real_escape_string($conn, $_POST["attrazione$i"] ?? '');
            $prezzo = $_POST["prezzo$i"] ?? '';
            if ($attrazione !== '') {
                $query = "UPDATE viaggio SET attrazione$i='$attrazione', prezzo$i=" . ($prezzo !== '' ? $prezzo : 'NULL') . " WHERE id_viaggio=$id_viaggio";
                mysqli_query($conn, $query);
            } else {
                $query = "UPDATE viaggio SET attrazione$i=NULL, prezzo$i=NULL WHERE id_viaggio=$id_viaggio";
                mysqli_query($conn, $query);
            }
        }

        for ($i = 1; $i <= 10; $i++) {
            $foto = "foto".$i;
            if (isset($_FILES[$foto]['name']) && $_FILES[$foto]['name'] != '') {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES[$foto]["name"]);
                $uploadOk = 1;
    
                $check = getimagesize($_FILES[$foto]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
    
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES[$foto]["tmp_name"], $target_file)) {
                        $query = "UPDATE viaggio SET $foto='$target_file' WHERE id_viaggio=$id_viaggio";
                        mysqli_query($conn, $query);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }

        header("Location: MieiViaggi.php");
        exit();
    } else {
        echo "Errore nell'aggiornamento del record: " . mysqli_error($conn);
    }
}

$conn->close();
?>