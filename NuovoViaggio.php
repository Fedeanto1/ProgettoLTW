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
    <title>Nuovo viaggio</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./stile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="logo.png" type="image/x-icon">
</head>
<body style=" overflow-y: auto; overflow-x: hidden;">
    <header class="barra-superiore">
    <div class="contenuto-header">
            <span style="display:flex; align-items: center;">
                <img src="logo.png" class="immagine-personalizzata">
                <span class="MuseRover" style="height:100%; display:flex; align-items: center; margin-left:0.5vw;"> Muse Rover </span>
            </span>
        </div>
    </header>
    <div id="success-banner" class="banner" style="margin-top:15vh;">
        <span>Viaggio caricato con successo</span>
        <button id="close-banner" onclick="chiudibanner()" style="display:flex; align-content:center;"><span class="material-symbols-outlined" style="color:white;">
        close
        </span></button>
    </div>
    <div id="loader" class="loader">
        <label class="caricamento" style="font-size:1vw;"> Caricamento in corso...</label>
        <div class="loading"></div>
    </div>

    <form id="formnuovo" method="post" action="crea2.php"  enctype="multipart/form-data" class="conteiner-nuovo" onsubmit="handleRegistrationSuccess();">
        <div style="display: flex; height: fit-content;">
            <div id="finestrasinistra" class="finestrasx">
                <div class="elem-cont"> 
                    <span>
                    <label for="inputpartenza">Partenza</label>
                    <input type="text" id="inputpartenza" name="inputpartenza" style="font-size:1vw;" required>
                    </span>

                    <span>
                    <label for="inputarrivo">Destinazione</label>
                    <input type="text" id="inputarrivo" name="inputarrivo" style="font-size:1vw;" required>
                    </span>
                </div>
                <div class="elem-cont" style="justify-content:space-between;">
                    <span>
                    <label for="data-partenza">Data partenza</label>
                    <input type="date" id="data-partenza" name="data-partenza" style="font-size:1vw;" required>
                    </span>
                    <span>
                    <label for="data-ritorno">Data ritorno</label>
                    <input type="date" id="data-ritorno" name="data-ritorno"  style="font-size:1vw;" required>
                    </span>
                </div>
                <div class="elem-cont" style="justify-content:normal;">
                    <span style="width:100%;">
                    <label for="alloggio">Il mio alloggio</label>
                    <input type="text" id="alloggio" name="alloggio" style="font-size:1vw;">
                    </span>
                </div>
                <div id="conteinerattrazioni" class="containerattrazioni">
                    <div id="insieme" class="att-cost"style="width: 90%; margin-right: 0%; display: flex; height:2vw; justify-content:space-between; align-items:center;">
                        <span style="width:70%;">
                            <label for="visita0">Da visitare</label>
                            <input type="text" id="visita0" name="visita0" style="width: 70%; font-size:1vw;">
                        </span>
                        <span style="width:30%;">
                            <label for="prezzo0">Costo (€)</label>
                            <input type="number" id="prezzo0" name="prezzo0" min="0" style="width:40%; font-size:1vw;">
                        </span>
                    </div>
                    <div style="width: 10%; display: flex; height:2vw; justify-content:space-between;">
                    <span style="align-content:center;"><button type="button" id="plus" class="più"> <b>+</b></button></span>
                    <span style="align-content:center;"><button type="button" id="per" class="più" style="display:none;"> <b>x</b></button></span>
                    </div>          
                </div>
                <div style="margin:2%; display: flex; align-items:center;">
                    <span>Voto viaggio</span>
                    <span id ="voto" class="rating">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1"></label>
                    </span>                  
                </div>
                <div class="conteiner-commento">
                    <label for="commento"> Commento</label>
                    <textarea id="commento" name="commento" rows="4" style="width:100%; font-size:1vw;"> </textarea>
                </div>
            </div>
            <div class="finestradx">
                <label class="custum-file-upload" for="images">
                    <div class="icon-foto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> 
                            </g>
                        </svg>
                    </div>
                    <div class="text">
                        <span id="file-names" style="font-size: 1vw;">Click to upload images (max 10)</span>
                    </div>
                    <input type="file" id="images" name="images[]" multiple onchange="displaySelectedFiles()">
                </label>
            </div>

            <script>
                function displaySelectedFiles() {
                    const input = document.getElementById('images');
                    const fileNamesSpan = document.getElementById('file-names');
                    const files = input.files;
                    let fileNames = '';
                    for (let i = 0; i < files.length; i++) {
                        fileNames += files[i].name + ', ';
                    }
                    fileNames = fileNames.substring(0, fileNames.length - 2);
                    fileNamesSpan.textContent = fileNames;
                }
            </script>
        </div>
        <div class="infondo">
            <button type="submit" class="invio-nuovo" id="crea" style="font-size:1vw;"> <b> CREA </b></button>
        </div>
    </form>
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
            <span class="material-symbols-outlined" style="font-size:2vw;">
                <a href="logout.php" style="text-decoration: none; color:white;">person</a>
            </span>
        </div>
    </footer>

    <script src="nuovoviaggio.js"></script>
    <script>
        document.getElementById('formnuovo').addEventListener('submit', function(event) {
        showLoader();
    });
    function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }
    </script>
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
    function handleRegistrationSuccess() {
            localStorage.setItem('registrationSuccess', 'true');
            window.location.href = 'NuovoViaggio.php';
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
