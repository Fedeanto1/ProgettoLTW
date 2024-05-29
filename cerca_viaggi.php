<?php
    include 'db_connect.php'; 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['destinazione'])) {
        // Pulisci e sanitizza la destinazione inserita dall'utente
        $destinazione = mysqli_real_escape_string($conn, $_GET['destinazione']);
        
        // Query per recuperare i viaggi con la destinazione specificata
        $query = "SELECT * FROM viaggi v LEFT JOIN attrazioni_viaggi a on v.id_viaggio=a.id_viaggio WHERE destinazione='$destinazione' ORDER BY v.id_viaggio DESC";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<div style=\" width: 100vw;\">";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div style=\" width: 38vw; display:inline-block; padding:3vw; margin-top: 2vw; margin-bottom: 2vw; margin-left: 3vw; margin-right:3vw; box-shadow: rgb(0 0 0 / 10%) 0 0 8px; font-size: 1vw;\">";
                    echo "<div style=\"display: flex; flex-direction:column;\">";
                        echo "<div style=\"display:flex; justify-content: space-between; width: 100%;\">";
                            echo "<div>";
                                echo "<div style=\"margin-bottom:1vw;\"> Città di partenza: " . $row['partenza'] . "</div>";
                                echo "<div style=\"margin-bottom:1vw;\"> Città di destinazione: " . $row['destinazione'] . "</div>";
                                echo "<div style=\"margin-bottom:1vw;\"> Data andata: " . $row['andata'] . "</div>";
                                echo "<div style=\"margin-bottom:1vw;\"> Data ritorno:" . $row['ritorno'] . "</div>";
                                if ($row['attrazione'] !== null){
                                    echo "<div style=\"margin-bottom:1vw;\">";
                                    echo "<span> Attrazione: " . $row['attrazione'] . "</span>";
                                    echo "<span> Prezzo: " . $row['prezzo'] . "</span>";
                                    echo "</div>";
                                }
                            echo "</div>";
                            echo "<div class=\"center\" style=\" width: 21vw; height: 14vw;\">";
                            if ($row['foto'] !== null){
                                echo '<img src="' . $row['foto'] . '" style="width:100%; height:100%;" />';
                            }
                            echo "</div>";
                        echo "</div>";
                        echo "<div>";
                            $voto=$row['voto'];
                            echo "<div style=\"margin-bottom:1vw;\"> <div style=\"align-items:center;\">"; 
                            for ($voto; $voto>0; $voto--){
                                echo "<span class=\"material-symbols-outlined\" style=\"color:#ffc300; font-size: 1vw;\">star</span>";
                            }
                            echo "</div>";
                            echo "<div style=\" \"> <em>" . $row['commento'] . " </em> </div> </div>";
                            echo "<div class=\"author\"> Pubblicato da <b> $username </b> in data " . $row['pubblicazione'] . "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
        echo "</div>";
        }else {
            echo "<p>Nessun viaggio trovato per la destinazione '$destinazione'.</p>";
        }
        // Chiudi la connessione al database
        $conn->close();
    }
    else {
        echo "<p> Nessun viaggio trovato per la destinazione. </p>";
    }
?>