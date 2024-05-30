<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
    <link rel="stylesheet" href="./stile.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="centered">
    <form method="post" action="registra.php" name="registrati" id="registrati" class="form" style="height: auto;" onsubmit="handleRegistrationSuccess();">
    <div>
        <a class="material-symbols-outlined" style="color:#34568b;" href="./Index.html">home</a> 
    </div>
    <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
        Registrati
    </div>
    <?php if (isset($_GET['error'])) { ?>
    <div class="error-message"><?php echo $_GET['error']; ?></div>
    <?php } ?>
    <div class="input-container" stile="margin-left: 2rem; margin-right: 2rem; width: 85%;">
        <input type="text" id="nome" name="nome" placeholder="Nome" required>
        <input type="text" id="cognome" name="cognome" placeholder="Cognome" required>
        <input type="text" id="username" name="username" placeholder="Username" required>
    </div>
    <div class="input-container"stile="margin-left: 2rem; margin-right: 2rem; width: 85%;">
        <input type="email" id="email" name="email" placeholder="Email" required>
    </div>
    <div class="input-container"stile="margin-left: 2rem; margin-right: 2rem; width: 85%;">
        <input type="password" id="password" name="password" placeholder="Password" required>
    </div>
    <div class="input-container">
        <select name="domanda_sicurezza" id="domanda_sicurezza" required>
            <option value="" disabled selected>Domanda di Sicurezza</option>
            <option value="nome_madre">Nome da nubile di tua madre?</option>
            <option value="primo_animale">Nome del tuo primo animale domestico?</option>
            <option value="città_nascita">Città in cui sei nato?</option>
        </select>
    </div>
    <div class="input-container"stile="margin-left: 2rem; margin-right: 2rem; width: 85%;">
        <input type="text" name="risposta_sicurezza" id="risposta_sicurezza" placeholder="Risposta di sicurezza" required>
    </div>
    <div class="center">
        <button type="submit" class="submit">Registrati</button>
    </div>
    <div class="signup-link">
        Hai già un account?
        <a href="accedi.php">Accedi</a>
    </div>
</form>

    </div>
</span>     
</div>
<script>
        function handleRegistrationSuccess() {
            localStorage.setItem('registrationSuccess', 'true');
            window.location.href = 'accedi.php';
        }
</script>
</body>
</html>
