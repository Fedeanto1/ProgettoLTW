function addFavorite(viaggio, utente) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "favorite.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log("Favorite added successfully");
        }
    };

    xhr.send("viaggio=" + viaggio + "&utente=" + utente);
}

document.getElementById('person-icon').addEventListener('click', function() {
    var popup = document.createElement('div');
    popup.classList.add('popup');

    var option1 = document.createElement('a');
    option1.href = 'modifica_profilo.php'; 
    option1.textContent = 'Modifica Profilo';
    option1.style.display = 'block';

    var option2 = document.createElement('a');
    option2.href = 'Logout.php'; 
    option2.textContent = 'Logout';
    option2.style.display = 'block'; 

    popup.appendChild(option1);
    popup.appendChild(option2);

    document.body.appendChild(popup);
});

window.addEventListener('click', function(event) {
    var popup = document.querySelector('.popup');
    if (popup && !popup.contains(event.target) && event.target !== document.getElementById('person-icon')) {
        popup.remove();
    }
});
