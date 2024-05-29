<?php
include 'db_connect.php';
session_start();

if(!isset($_SESSION['userid'])) {
    header("Location: accedi.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="stile.css">
    <title>Miei viaggi</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <script src="foto.js">
    </script>
    <script>
        function openGoogleSearch(query) {
            window.open('https://www.google.com/search?q=' + encodeURIComponent(query));
        }
    </script>
</head>
<body>
    <?php $username=$_SESSION['username']; ?>
    <header class="barra-superiore">
        <div class="contenuto-header">
            <span style="display:flex; align-items:center;"> 
                <img src="logo.png" class="immagine-personalizzata"> 
                <span class="MuseRover" style="height:100%; display:flex; align-items: center; margin-left:0.5vw;"> Muse Rover </span> 
            </span>
            <span style="font-size: 2vw; color:white; display:flex;align-items: center;"> <b> <?php echo "Ciao ". $username . "!"?></b></span>
        </div>
    </header>
    <div class='containerHome'>
        
        <div id="success-banner" class="banner" style="margin-top:15vh;">
            <span>Viaggio modificato con successo</span>
            <button id="close-banner" onclick="chiudibanner()" style="display:flex; align-content:center;"><span class="material-symbols-outlined" style="color:white;">
            close
            </span></button>
        </div>

        <div id="delete-banner" class="banner" style="margin-top:15vh;">
            <span>Viaggio eliminato con successo</span>
            <button id="close-banner" onclick="chiudibanner()" style="display:flex; align-content:center;"><span class="material-symbols-outlined" style="color:white;">
            close
            </span></button>
        </div>

        <div id="confirmBanner">
            <div style="margin-bottom:1vw;">Confermi di voler eliminare il post?</div>
            <div style="display:flex; justify-content:space-evenly;">
            <button onclick="eliminaPost()" class="conf-ann" style="background-color: #ff4545;">Conferma</button>
            <button onclick="nascondiConferma()" class="conf-ann">Annulla</button>
            </div>
        </div>
    <?php
    ini_set('display_errors', 'Off');
    include 'db_connect.php';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_SESSION['userid'];
    $query="SELECT * FROM viaggio v JOIN utenti u on v.autore=u.id WHERE v.autore=$id ORDER BY id_viaggio DESC";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class=\"post\">";
            echo "<div class=\"inpost\">";
            echo "<div style=\"display:flex; justify-content: space-between; width: 100%;\">";
            echo "<div style=\"margin-bottom:0.5vw; width:40%;\">";

            echo "<div style=\"display:flex; justify-content:space-between;\">";
                                    echo "<span style=\"margin-bottom:0.5vw; display:flex; align-items:center;\"> <span class=\"material-symbols-outlined\" style=\"color: black; font-size:1.5vw; margin-right: 0.5vw; \">
                                    flight_takeoff
                                    </span>" . stripslashes($row['partenza']) . "</span>";
                                    echo "<span style=\"margin-bottom:0.5vw; display:flex; align-items:center; margin-left:2vw;\"> <span class=  \"material-symbols-outlined\" style=\"color:black; font-size:1.5vw; margin-right: 0.5vw;\">
                                    flight_land
                                    </span> " . stripslashes($row['destinazione']) . "</span>";
                                echo "</div>";
                                echo "<div style=\"display:flex; justify-content:space-between;\">";
                                echo "<span style=\"margin-bottom:0.5vw; \"> Dal: " . date("d-m-Y", strtotime($row['andata'])) . " </span><span style=\"margin-bottom:0.5vw; \">Al: " . date("d-m-Y", strtotime($row['ritorno'])) . "</span>";
                                echo "</div>";
                                $destinazione=$row['destinazione'];
                                $alloggio=$row['alloggio'];
                                if (isset($alloggio) && !empty($alloggio)) {
                                echo "<div style=\"display:flex; align-items:center; margin-bottom:0.5vw;\"> <span class=\"material-symbols-outlined\" style=\"color: black; font-size:1.5vw; margin-right: 0.5vw; \">hotel</span><span>
                                <a href=\"https://www.google.com/search?q=$alloggio $destinazione\" target=\"_blank;\" class=\"attrazione-link\">". stripslashes($row['alloggio']) . "</a></span></div>";
                                };
                                $attrazione=$row['attrazione1'];
                                if ($attrazione !== null){
                                    echo "<div> Da visitare: </div>";
                                }
    
                                for ($i=1; $attrazione!==null; $i++){
                                    $a="attrazione".$i;
                                    $p="prezzo".$i;
                                    $attrazione=$row[$a];
                                    $prezzo=$row[$p];
                                    if ($attrazione!== null){
                                        echo "<div style=\"display:flex; align-items:center; justify-content:space-between;\">";
                                        echo "<span style=\"display:flex; align-items:center; position:relative;\">";
                                        echo "<span class=\"material-symbols-outlined\" style=\"color:black; font-size:1.5vw; margin-right:0.5vw;\">";
                                        echo "distance";
                                        echo "</span>";
                                        echo "<a href=\"#\" onclick=\"openGoogleSearch('". addslashes($attrazione) . " " . addslashes($destinazione) ."'); return false;\" class=\"attrazione-link\">" . stripslashes($attrazione) . "</a>";
                                        echo "<span class=\"prezzo\">" . $prezzo . "€</span>";
                                        echo "</span>";
                                        echo "</div>";
                                    }
                                }
                            echo "</div>";

            $carouselId = 'carousel' . $row['id_viaggio'];
            echo '<div id="' . $carouselId . '" class="carousel" style="width:21vw; height:14vw;">';
            echo '<div class="carousel-inner">';

            for ($i = 1; $i <= 10; $i++) {
                $photo = 'foto' . $i;
                if (!empty($row[$photo])) {
                    $activeClass = $i === 1 ? 'active' : '';
                    echo '<div class="carousel-item ' . $activeClass . '">';
                    echo '<img src="' . $row[$photo] . '" alt="Foto ' . $i . '" style="height:14vw; width:21vw;">';
                    echo '</div>';
                }
            }

            echo '</div>'; 
            if (!empty($row['foto2'])){
                echo '<div class="carousel-controls">';
                echo '<button class="carousel-control" onclick="prevSlide(\'' . $carouselId . '\')">&#10094;</button>';
                echo '<button class="carousel-control" onclick="nextSlide(\'' . $carouselId . '\')">&#10095;</button>';
                echo '</div>'; 
                } else {
                    echo "<p class=\"vuoto\"></p>";
                }
            echo '</div>';

            echo "</div>";
            echo "<div>";

            echo "<div>";
                $voto=$row['voto'];
                echo "<div style=\"margin-bottom:1vw;\"> <div style=\"align-items:center;\">"; 
                for ($voto; $voto>0; $voto--){
                    echo "<span class=\"material-symbols-outlined\" style=\"color:#ffc300; font-size: 1vw;\">star</span>";
                }
                echo "</div>";
                echo "<div style=\" \"> <em>" . stripslashes($row['commento']) . " </em> </div> </div>";
            echo "</div>";
            echo "<div style=\"display:flex; align-items:center;\">";
                echo "<form action=\"modifica_viaggio.php\" method=\"GET\" style=\"display:inline; margin-right:0.5vw;\">";
                    echo "<input type=\"hidden\" name=\"id_viaggio\" value=\"" . $row['id_viaggio'] . "\">";?>
                    <button type="submit" class="edit-button">
                        <svg class="edit-svgIcon" viewBox="0 0 512 512">
                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                        </svg>
                    </button><?php
                echo "</form>";
                    echo "<input type=\"hidden\" id=\"id_viaggio\" name=\"id_viaggio\" value=\"" . $row['id_viaggio'] . "\">";?>
                    <button class="delete-button"  onclick="mostraConferma()" id="elimina">
                        <svg class="delete-svgIcon" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                        </svg>
                    </button>
                    <?php
            echo "</div>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }

    $conn->close();
    ?>
    </div>
    <footer class="barra-inferiore">
        <div class="icona">
            <span class="material-symbols-outlined" style="font-size:2vw;">
                <a href="HomePage.php" style="text-decoration: none; color:white;">home</a>
            </span>
        </div>
        <div class="icona">
            <span class="material-symbols-outlined" style="font-size:2vw;">
                <a href="MieiViaggi.php" style="text-decoration: none; color:white;">flight</a>
            </span>
        </div>
        <div class="icona">
            <span class="material-symbols-outlined" style="font-size:2vw;">
                <a href="NuovoViaggio.php" style="text-decoration: none; color:white;">add_circle</a>
            </span>
        </div>
        <div class="icona">
            <span class="material-symbols-outlined" style="font-size:2vw;">
                <a href="VoliSalvati.php" style="text-decoration: none; color:white;">star</a>
            </span>
        </div>
        <div class="icona">
        <div class="icona">
            <span id="person-icon" class="material-symbols-outlined" style="font-size:2vw;text-decoration: none; color:white;">
                person
            </span>
        </div>
        </div>
    </footer>

    <script src="mieiviaggi.js">
    </script>
</body>
</html>