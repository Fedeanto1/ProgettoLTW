<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./stile.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body style="background-color:#f0f0f0;">
    <div id="success-banner" class="banner">
        <span>Registrazione effettuata con successo</span>
        <button id="close-banner" onclick="chiudibanner()" style="display:flex; align-content:center;"><span class="material-symbols-outlined" style="color:white;">
        close
        </span></button>
    </div>
    <div class="centered">
        <form action="login.php" method="post" name="login" class="form">
            <div>
                <a class="material-symbols-outlined" href="./Index.html" style="color:#34568b;">home</a> 
            </div>
            <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
                Accedi
            </div>
            <?php if (isset($_GET['error'])){ ?>
            <div id="error-message" class="error-message"style=" margin-top: 0.5vw; color:red; font-size:1.2vw;"><?php echo $_GET['error']; ?></div>
            <?php } ?>
            <div class="input-container">
            <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-container">
            <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="center">
            <button type="submit" class="submit" > Login </button>
            </div>
            <div class="signup-link">
                <a href="">Forgot Password?</a>
            </div>
            <div class="signup-link">
                Don't have an account?
                <a href="registrati.php">Sign up</a>
            </div>
        </form>
    </div>   
</div>
<!--<div id="slideshow">
  <div class="slide active" style="background-image: url('sfondo/roma.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/londra.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/dubai.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/spiaggia.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/tokyo.jpg');"></div>-->
  <!-- Aggiungi altre immagini se necessario -->
<!--</div

<script src="index.js"></script>-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const registrationSuccess = localStorage.getItem('registrationSuccess');
        
        if (registrationSuccess === 'true') {
            document.getElementById('success-banner').style.display = 'flex';
            localStorage.removeItem('registrationSuccess');
        }
    });
    function chiudibanner(){
        document.getElementById('success-banner').style.display = 'none';
    }
    window.onload = function() {
        var successBanner = document.getElementById('success-banner');

        setTimeout(function() {
            if (successBanner.style.display === 'flex') {
                successBanner.style.display = 'none';
            }
        }, 5000);
    };
</script>

</body>
</html>