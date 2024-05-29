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
<body style="background-color:#f0f0f0; display: flex; flex-direction: column;">
    <div class="pannello pannello4">
        <img src="logo.png" class="immagine-personalizzata">
        <span class="MuseRover" style="padding-left: 2vw; color: #000000; font-size: 1.5vw">Muse Rover</span></div>
    <div class="centered" style="padding-top: 5vw;">
        <form  method="post" action="registra.php" name="registrati" id="registrati" class="form" style="height: auto;" onsubmit="handleRegistrationSuccess();">
            <div>
                <a class="material-symbols-outlined" style="color:#34568b;" href="./Index.html">home</a> 
            </div>
            <div class="form-title" style="padding-bottom: 0rem; font-size: 110%; text-align: center;">
                Registrati
            </div>
            <?php if (isset($_GET['error'])){ ?>
            <div class="error-message"><?php echo $_GET['error']; ?></div>
            <?php } ?>
            <div class="input-container">
                <input type="text" id="nome"name="nome" placeholder="Nome" required>
                <input type="text" id="cognome" name="cognome" placeholder="Cognome" required>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-container">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <span>
            </span>
            </div>
            <div class="input-container">
            <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="center">
            <button type="submit" class="submit"> Sign up </button>
            </div>
            <div class="signup-link">
            Hai già un account?
            <a href="accedi.php">Accedi</a>
            </div>
        </form>
    </div>
</span>     
</div>
<div id="slideshow">
  <div class="slide active" style="background-image: url('sfondo/tokyo.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/londra.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/roma.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/spiaggia.jpg');"></div>
  <div class="slide" style="background-image: url('sfondo/dubai.jpg');"></div>
</div>

<script>
let slideIndex = 0;
showSlides();

function showSlides() {
  let slides = document.getElementsByClassName("slide");
  for (let i = 0; i < slides.length; i++) {
      slides[i].style.opacity = 0;
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.opacity = 1;
  setTimeout(showSlides, 3000); // Cambia immagine ogni 3 secondi
}
</script>
<script>
        function handleRegistrationSuccess() {
            localStorage.setItem('registrationSuccess', 'true');
            window.location.href = 'accedi.php';
        }
</script>
</body>
</html>
