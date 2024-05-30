<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reimposta Password</title>
    <link rel="stylesheet" href="./stile.css">
</head>
<body style="background-color:#f0f0f0;">
    <div class="centered">
        <form action="processa_reimposta_password.php" method="post" class="form">
            <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
                Imposta una nuova password
            </div>
            <?php if (isset($_GET['error'])) { ?>
            <div id="error-message" class="error-message" style="margin-top: 0.5vw; color:red; font-size:1.2vw;"><?php echo $_GET['error']; ?></div>
            <?php } ?>
            <div class="input-container">
                <input type="password" id="new_password" name="new_password" placeholder="Nuova Password" required>
            </div>
            <div class="input-container">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Conferma Password" required>
            </div>
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($_GET['username']); ?>">
            <div class="center">
                <button type="submit" class="submit">Salva Modifiche</button>
            </div>
        </form>
    </div>   
</body>
</html>