<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupero Password</title>
    <link rel="stylesheet" href="./stile.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body style="background-color:#f0f0f0;">
    <div class="centered">
        <div id="email-form">
            <form id="emailForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
                    Recupero Password
                </div>
                <?php if (isset($_GET['error'])) { ?>
                <div id="error-message" class="error-message" style="margin-top: 0.5vw; color:red; font-size:1.2vw;"><?php echo $_GET['error']; ?></div>
                <?php } ?>
                <div class="input-container">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="center">
                    <button type="submit" class="submit">Invia</button>
                </div>
            </form>
        </div>

        <div id="security-question-form" class="hidden">
            <!-- Questo div verrà popolato dinamicamente -->
        </div>
    </div>   

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connect.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Mappa delle domande di sicurezza
        $domande = [
            'nome_madre' => 'Nome da nubile di tua madre?',
            'primo_animale' => 'Nome del tuo primo animale domestico?',
            'città_nascita' => 'Città in cui sei nato?'
        ];

        // Ricevi l'email dall'utente
        $email = $conn->real_escape_string($_POST['email']);

        // Esegui una query per verificare se l'email esiste nel database
        $query = "SELECT * FROM utenti WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $domanda_sicurezza = $row['domanda_sicurezza'];

            // Ottieni il testo completo della domanda di sicurezza
            $domanda_completa = isset($domande[$domanda_sicurezza]) ? $domande[$domanda_sicurezza] : 'Domanda di sicurezza';

            // Genera il form della domanda di sicurezza
            echo "<script>
                document.getElementById('email-form').classList.add('hidden');
                document.getElementById('security-question-form').classList.remove('hidden');
                document.getElementById('security-question-form').innerHTML = `
                    <form action='verifica_risposta.php' method='post' class='form'>
                        <div class='form-title' style='padding-bottom: 0rem; font-size: 110%; text-align: center; line-height:1.25rem'>
                            Rispondi alla Domanda di Sicurezza:
                        </div>
                        <div class='input-container'>
                            <label for='domanda'>" . htmlspecialchars($domanda_completa) . "</label>
                            <input type='hidden' name='username' value='" . htmlspecialchars($username) . "'>
                            <input type='text' id='risposta_sicurezza' name='risposta_sicurezza' placeholder='Risposta' required>
                        </div>
                        <div class='center'>
                            <button type='submit' class='submit'>Verifica</button>
                        </div>
                    </form>
                `;
            </script>";
        } else {
            echo '<div id="error-message" class="error-message" style="margin-top: 0.5vw; color:red; font-size:1.2vw;">L\'indirizzo email fornito non è associato a un account.</div>';
        }

        // Chiudi la connessione al database
        $conn->close();
    }
    ?>
</body>
</html>