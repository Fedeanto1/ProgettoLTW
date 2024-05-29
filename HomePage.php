
<?php
include 'db_connect.php';
session_start();

if(!isset($_SESSION['userid'])) {
    header("Location: accedi.php");
    exit();
}

$userId = $_SESSION['userid'];

$preferiti_query = "SELECT viaggio FROM preferiti WHERE utente = ?";
$stmt = $conn->prepare($preferiti_query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$preferiti_result = $stmt->get_result();

$preferiti = [];
while ($row = $preferiti_result->fetch_assoc()) {
    $preferiti[] = $row['viaggio'];
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="stile.css">
    <title>Home page</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <script src="foto.js">
    </script>
    <script>

        function openGoogleSearch(query) {
            window.open('https://www.google.com/search?q=' + encodeURIComponent(query));
        }

    </script>
</head>
<body style="background-color:#f0f0f0;">
    <header class="barra-superiore">
        <div class="contenuto-header">
            <span style="display:flex; align-items: center;">
                <img src="logo.png" class="immagine-personalizzata">
                <span class="MuseRover" style="height:100%; display:flex; align-items: center; margin-left:0.5vw;"> Muse Rover </span>
            </span>
            <span class="group">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                <g>
                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                </g>
                </svg>
                <form id="searchForm" method="GET" style="display:flex;">
                    <input type="search" class="searchbar" id="destinazione" name="destinazione" placeholder="Cerca una destinazione" />
                </form>
                <script>
                    document.getElementById("destinazione").addEventListener("keyup", function(event) {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                            document.getElementById("searchForm").submit();
                        }
                    });
                </script>
            </span>
        </div>
    </header>
    <div class='containerHome'>
    <?php
    ini_set('display_errors', 'Off');
    include 'db_connect.php';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = "";
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['destinazione'])) {
        $destinazione = mysqli_real_escape_string($conn, $_GET['destinazione']);
        $query = "SELECT * FROM viaggio v LEFT JOIN utenti u ON v.autore=u.id WHERE destinazione LIKE '%$destinazione%' ORDER BY v.id_viaggio DESC";
        $result = mysqli_query($conn, $query);
    } else {
        $query = "SELECT * FROM viaggio v LEFT JOIN utenti u ON v.autore=u.id ORDER BY v.id_viaggio DESC";
        $result = mysqli_query($conn, $query);
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $viaggio_id = $row['id_viaggio'];
            $is_favorite = in_array($viaggio_id, $preferiti) ? 'checked' : '';

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
            <a href=\"https://www.google.com/search?q=$alloggio $destinazione\" target=\"_blank;\" style=\"color: #34568b;\" class=\"attrazione-link\">". stripslashes($row['alloggio']) . "</a></span></div>";
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
                    echo "<a href=\"#\" onclick=\"openGoogleSearch('". addslashes($attrazione) . " " . addslashes($destinazione) ."'); return false;\" style=\"color: #34568b; \" class=\"attrazione-link\">" . stripslashes($attrazione) . "</a>";
                    echo "<span class=\"prezzo\">" . $prezzo . "€</span>";
                    echo "</span>";
                    echo "</div>";
                }
            }
            echo "</div>";

            echo "<div id=\"mapPreview\"></div>";


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
                echo "<div style=\" display: flex; justify-content: space-between; width: 100%; align-content: center;\">";
                    echo "<div class=\"author\"> Pubblicato da <b> " . $row['username'] . " </b> in data " . $row['pubblicazione'] . "</div>";
                    echo "<div id =\"voto\" class=\"rating\">";
                    $favorite = "favorite" . $row['id_viaggio']; 
                        echo "<input type=\"checkbox\" id=\"$favorite\" onclick=\"addFavorite(" . $row['id_viaggio'] . ", " . $userId. ");\" $is_favorite>";
                        echo "<label for=\"$favorite\"></label>";

                echo "</div>";
                echo "</div>";
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
            <span id="person-icon" class="material-symbols-outlined" style="font-size:2vw;text-decoration: none; color:white;">
                person
            </span>
        </div>
    </footer>
    <script src="homepage.js">
    </script>
</body>
</html>