function mostraConferma() {
    document.getElementById('confirmBanner').style.display = 'block';
}

function nascondiConferma() {
    document.getElementById('confirmBanner').style.display = 'none';
}

function eliminaPost() {
    var idViaggio = document.getElementById('id_viaggio').value;
    var formData = new FormData();
    formData.append('id_viaggio', idViaggio);

    fetch('elimina_viaggio.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        nascondiConferma();
        localStorage.setItem('deleteSuccess', 'true');
        window.location.href = 'MieiViaggi.php';
    })
    .catch(error => console.error('Errore:', error));
}
document.addEventListener('DOMContentLoaded', function () {
        const registrationSuccess = localStorage.getItem('deleteSuccess');
        
        if (registrationSuccess === 'true') {
            document.getElementById('delete-banner').style.display = 'flex';
            localStorage.removeItem('deleteSuccess');
        }
    });

    function handleRegistrationSuccess() {
        localStorage.setItem('deleteSuccess', 'true');
        window.location.href = 'MieiViaggi.php';
}


document.addEventListener('DOMContentLoaded', function () {
        const registrationSuccess = localStorage.getItem('registrationSuccess');
        
        if (registrationSuccess === 'true') {
            document.getElementById('success-banner').style.display = 'flex';
            localStorage.removeItem('registrationSuccess');
        }
    });

function chiudibanner(){
        document.getElementById('success-banner').style.display = 'none';
        document.getElementById('delete-banner').style.display = 'none';
    }

window.onload = function() {
    var successBanner = document.getElementById('success-banner');
    var deleteBanner = document.getElementById('delete-banner');

    setTimeout(function() {
        if (successBanner.style.display === 'flex') {
            successBanner.style.display = 'none';
        }
        if (deleteBanner.style.display === 'flex') {
            deleteBanner.style.display = 'none';
        }
    }, 5000);
};

document.getElementById('person-icon').addEventListener('click', function() {
    
    var popup = document.createElement('div');
    popup.classList.add('popup');

    var option1 = document.createElement('a');
    option1.href = 'modifica_profilo.html'; 
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