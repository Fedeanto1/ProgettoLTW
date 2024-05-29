<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Cambia Password</title>
    <link rel="stylesheet" href="./stile.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">


</head>
<body style="display: flex; flex-direction: column;">
    <div class="pannello pannello4">
        <img src="logo.png" class="immagine-personalizzata">
        <span class="MuseRover" style="padding-left: 2vw;">Muse Rover</span></div>
    <div class="contenuto-entrypage" style="display: grid; grid-template-columns: repeat(2, 0fr); gap: 3vw; place-content: center; background-color: #f0f0f0; height: 80vh;">
    <form action="change_password.php" method="post" class="form">
        <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
            Modifica Password
        </div>
        <?php
    session_start();
    if (isset($_SESSION['password_error'])) {
        echo '<p style="color: red; text-align: center;">' . $_SESSION['password_error'] . '</p>';
        unset($_SESSION['password_error']);
    }
    if (isset($_SESSION['password_success'])) {
        echo '<p style="color: green; text-align: center;">' . $_SESSION['password_success'] . '</p>';
        unset($_SESSION['password_success']);
    }
    ?>
        <div class="input-container">
            <input type="password" id="old_password" name="old_password" placeholder="Vecchia Password" required>
        </div>
        <div class="input-container">
            <input type="password" id="new_password" name="new_password" placeholder="Nuova Password" required>
        </div>
        <div class="input-container">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Conferma Password" required>
        </div>
        <div class="center">
            <button type="submit" class="submit">Salva Modifiche</button>
        </div>
    </form>

    <form action="change_username.php" method="post" class="form">
        <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
            Modifica Username
        </div>
        <?php
    if (isset($_SESSION['username_error'])) {
        echo '<p style="color: red; text-align: center;">' . $_SESSION['username_error'] . '</p>';
        unset($_SESSION['username_error']);
    }
    if (isset($_SESSION['username_success'])) {
        echo '<p style="color: green; text-align: center;">' . $_SESSION['username_success'] . '</p>';
        unset($_SESSION['username_success']);
    }
    ?>
        <div class="input-container">
            <input type="text" id="new_username" name="new_username" placeholder="Nuovo Username" required>
        </div>
        <div class="center">
            <button type="submit" class="submit">Salva Modifiche</button>
        </div>
    </form>
</div>
<div class="pannello pannello4" style="background-color: #f0f0f0;">
    <a href="HomePage.php" class="submit" style="width: 50vw;"> torna alla Home </a>
</div>
</body>
</html>