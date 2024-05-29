<?php
    session_start();
    include 'db_connect.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //echo "<pre>"; print_r($_POST); echo "</pre>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id= $_SESSION['userid'];
    $partenza =$conn->real_escape_string($_POST['inputpartenza']);
    $destinazione = $conn->real_escape_string($_POST['inputarrivo']);
    $datapartenza = $conn->real_escape_string($_POST['data-partenza']);
    $dataritorno = $conn->real_escape_string($_POST['data-ritorno']);
    $alloggio=$conn->real_escape_string($_POST['alloggio']);
    $attrazione=$conn->real_escape_string($_POST['visita0']);
    $costo=$conn->real_escape_string($_POST['prezzo0']);
    $commento=$conn->real_escape_string($_POST['commento']);
    $voto=$conn->real_escape_string($_POST['rating']);
    $filePath = "";

    $sql = "INSERT INTO viaggio (autore, partenza, destinazione, andata, ritorno, alloggio, voto, commento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $id, $partenza, $destinazione, $datapartenza, $dataritorno, $alloggio, $voto, $commento);
    if ($stmt->execute()) {
        //echo "Inserimento viaggio completato con successo!";
    } else {
        echo "Errore: " . $stmt->error;
    }
    $stmt->close();

    $id_viaggio = mysqli_insert_id($conn);

    if (isset($_POST['visita0'])) {
        $sql = "UPDATE viaggio SET attrazione1 = ? WHERE id_viaggio=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $attrazione, $id_viaggio);
        if ($stmt->execute()) {
           // echo "Inserimento attrazione-costo viaggio completato con successo!";
        } else {
            echo "Errore: " . $stmt->error;
        }
        $stmt->close();

        $sql = "UPDATE viaggio SET prezzo1 = ? WHERE id_viaggio=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $costo, $id_viaggio);
        if ($stmt->execute()) {
           // echo "Inserimento attrazione-costo viaggio completato con successo!";
        } else {
            echo "Errore: " . $stmt->error;
        }
        $stmt->close();
        for ($i = 1; isset($_POST['visita' . $i]); $i++) {
            $attrazione = $conn->real_escape_string($_POST['visita'.$i]);
            $costo = $conn->real_escape_string($_POST['prezzo'.$i]);
            $colonnaA="attrazione".($i+1);
            $colonnaP="prezzo" .($i+1);

            $sql = "UPDATE viaggio SET $colonnaA = ? WHERE id_viaggio=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $attrazione, $id_viaggio);
            if ($stmt->execute()) {
            // echo "Inserimento attrazione-costo viaggio completato con successo!";
            } else {
                echo "Errore: " . $stmt->error;
            }
            $stmt->close();

            $sql = "UPDATE viaggio SET $colonnaP = ? WHERE id_viaggio=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $costo, $id_viaggio);
            if ($stmt->execute()) {
            // echo "Inserimento attrazione-costo viaggio completato con successo!";
            } else {
                echo "Errore: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    
    if(isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        // Percorso della directory dove salvare le immagini
        $directory_salvataggio = "uploads/";
        $i=1;
        // Loop attraverso i file caricati
        foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            // Ottieni il nome del file
            $nome_file = $_FILES['images']['name'][$key];
            // Percorso temporaneo del file
            $percorso_temporaneo = $_FILES['images']['tmp_name'][$key];
            // Crea un percorso univoco per il file nel server
            $filePath = $directory_salvataggio . $nome_file;
            // Sposta il file dal percorso temporaneo al percorso di salvataggio definitivo
            if(move_uploaded_file($percorso_temporaneo, $filePath)) {
                //echo "File $nome_file caricato con successo.<br>";
                $colonnafoto="foto".$i;
                $sql = "UPDATE viaggio SET $colonnafoto = ? WHERE id_viaggio=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $filePath, $id_viaggio);
                if ($stmt->execute()) {
                // echo "Inserimento attrazione-costo viaggio completato con successo!";
                } else {
                    echo "Errore: " . $stmt->error;
                }
                $stmt->close();
            
            }
            $i++;
        }
    }
    $conn->close();

    $redirect_url = "NuovoViaggio.php";
    header("Location: $redirect_url");
    }
    ?>