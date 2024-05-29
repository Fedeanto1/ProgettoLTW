<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['userid'])) {
    header("Location: accedi.php");
    exit();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_viaggio = $_GET['id_viaggio'];
$query = "SELECT * FROM viaggio WHERE id_viaggio = $id_viaggio";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stile1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Modifica Viaggio</title>
</head>
<body>
    <form action="aggiorna_viaggio.php" method="POST" style="margin-top: 5vh; margin-bottom: 5vh;" enctype="multipart/form-data" onsubmit="handleRegistrationSuccess()">
        <h1> <a class="material-symbols-outlined" href="MieiViaggi.php" style="position: relative; left:-34%; font-size: 1.5vw; color: #0147a2;">home</a>  Modifica Viaggio</h1>
        <div class="riga">
        <input type="hidden" name="id_viaggio" value="<?php echo $row['id_viaggio']; ?>">
        <span style="width:50%; display:flex">
        <label for="partenza">Partenza:</label>
        <input type="text" id ="partenza" name="partenza"  style="margin-left:1%;"value="<?php echo stripslashes($row['partenza']); ?>">
        </span>
        <span style="width:50%; display:flex;">
        <label for="destinazione">Destinazione:</label>
        <input type="text" id="destinazione" name="destinazione" style="margin-left:1%;" value="<?php echo stripslashes($row['destinazione']); ?>">
        </span>
        </div>
        <div class="riga">
        <span style="width:50%; display:flex;">
        <label for="andata">Andata:</label>
        <input type="date" id="andata" name="andata" style="margin-left:4.3%;" value="<?php echo $row['andata']; ?>">
        </span>
        <span style="width:50%; display:flex;">
        <label for="ritorno">Ritorno:</label>
        <input type="date" id="ritorno" name="ritorno" style="margin-left:11.2%;" value="<?php echo $row['ritorno']; ?>">
        </span>
        </div>
        <div class="riga">
        <label for="andata">Alloggio:</label>
        <input type="text" id="alloggio" name="alloggio" style="margin-left:1.4%;" value="<?php echo $row['alloggio']; ?>">
        </div>
        <div style="display:flex; width:100%;">
        <label for="commento">Commento:</label>
        <textarea id="commento" name="commento" rows="4" style="width:98%; margin-left:1%;"><?php echo stripslashes($row['commento']); ?></textarea>
        </div>

        <h3>Attrazioni</h3>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            $attrazione = "attrazione$i";
            $prezzo = "prezzo$i";
            if ($i<=9){
                echo "<div class=\"riga\">";
                echo "<span style=\"width:50%; display:flex;\">";
                echo "<label for=\"$attrazione\">Attrazione $i:</label>";
                echo "<input type=\"text\" id=\"$attrazione\" name=\"$attrazione\" class=\"marginesx\" value=\"" . htmlspecialchars(stripslashes($row[$attrazione] ?? '')) . "\">";
                echo "</span>";
                echo "<span style=\"width:50%; display:flex;\">";
                echo "<label for=\"$prezzo\">Prezzo $i:</label>";
                echo "<input type=\"number\" step=\"0.01\" id=\"$prezzo\" name=\"$prezzo\" class=\"marginesx\" value=\"" . htmlspecialchars(stripslashes($row[$prezzo] ?? '')) . "\">";
                echo "</span>";
                echo "</div>";
            }
            else {
            echo "<div class=\"riga\">";
            echo "<span style=\"width:50%; display:flex;\">";
            echo "<label for=\"$attrazione\">Attrazione $i:</label>";
            echo "<input type=\"text\" id=\"$attrazione\"name=\"$attrazione\" style=\"margin-left:1%;\"value=\"" . htmlspecialchars(stripslashes($row[$attrazione] ?? '')) . "\">";
            echo "</span>";
            echo "<span style=\"width:50%; display:flex;\">";
            echo "<label for=\"$prezzo\">Prezzo $i:</label>";
            echo "<input type=\"number\" id=\"$prezzo\"step=\"0.01\" name=\"$prezzo\" style=\"margin-left:1%;\"value=\"" . htmlspecialchars(stripslashes($row[$prezzo] ?? '')) . "\">";
            echo "</span>";
            echo "</div>";
            }
        }
        ?>

        <h3>Foto</h3>
        <?php
        echo "<div class=\"riga\">";
        for ($i = 1; $i <= 10; $i++) {
            $foto = "foto".$i;
            echo "<span style=\"width:50%;\">";
            echo "<label for=\"file-upload-$i\">Foto $i:</label>";
            if ($row[$foto] != null) {
                echo "<img src=\"" . $row[$foto] . "\" class=\"immagine\"><br>";
            }
            echo "<input type=\"file\" id=\"file-upload-$i\" name=\"$foto\"><br>";
            echo "</span>";
        }
        echo "</div>";
        ?>


        <button type="submit">Salva modifiche</button>
    </form>
    <script>
        function handleRegistrationSuccess() {
            localStorage.setItem('registrationSuccess', 'true');
            window.location.href = 'MieiViaggi.php';
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
