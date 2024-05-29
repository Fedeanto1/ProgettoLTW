$(document).ready(function() {
    var counter = 0;
    $("#plus").click(function() {
        counter++;
        if (counter!==0){
            document.getElementById("per").style.display="block";
        }
        console.log(counter);
        var nuovattrazione='<div id="insieme" class="att-cost" style="width: 90%; margin-right: 0%; display: flex; height:2vw; justify-content:space-between; align-items:center; font-size:1vw;">'+
                            '<span style="width:70%;">'+'<label for="visita'+counter+'" style="margin-right:1%;">Da visitare</label>'+'<input type="text" id="visita'+counter+'" name="visita'+counter+'" style="width: 70%; font-size:1vw;">'+'</span>'+
                            '<span style="width:30%;">'+'<label for="prezzo'+counter+'" style="margin-right:4px;">Costo (€)</label>'+'<input type="number" id="prezzo'+counter+'" name="prezzo'+counter+'" min="0" style="width:40%; font-size:1vw;">'+'</span>'+
                            '</div>';
        
            $("#conteinerattrazioni").append(nuovattrazione);
        if(counter==9){
            document.getElementById("plus").style.display="none";
        }
    })

    $("#per").click(function() {
        $("#conteinerattrazioni #insieme").last().remove();
        counter--;
        console.log(counter);
        if (counter==0){
            document.getElementById("per").style.display="none";
        }
        if (counter<9){
            document.getElementById("plus").style.display="block";
        }
    })

    $(".submit").click(async function(event){
        event.preventDefault();
        const cittapartenza=document.getElementById("inputpartenza").value;
        const cittaarrivo=document.getElementById("inputarrivo").value;
        console.log(cittapartenza);
        console.log(cittaarrivo);
        const apiKey = "f98540b5bdd64267b954628a3b507693"; 
        const url1 = `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(cittapartenza)}&key=${apiKey}&language=it&pretty=1`;

        try {
            const response = await fetch(url1);
            const data = await response.json();
            if (data.total_results > 0) {
            const results = data.results;
            // Cerca nelle risposte un risultato che sia classificato come città
            const cityResult = results.find(result => result.components._type === 'city');
            if (cityResult) {
                console.log("Il testo inserito è una città:", cityResult.formatted);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "crea2.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");

                var città = cityResult.formatted;

                xhr.send(JSON.stringify(città));
            } else {
                console.log("Il testo inserito non è una città.");
                alert("Inserisci una città di partenza valida!");
            }
            } else {
            console.log("Nessun risultato trovato per l'input fornito.");
            alert("Inserisci una città di partenza valida!");
            }
        } catch (error) {
            console.error("Errore nella richiesta API:", error);
        }

        const url2 = `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(cittaarrivo)}&key=${apiKey}&language=it&pretty=1`;
        try {
            const response2 = await fetch(url2);
            const data2 = await response2.json();
            if (data2.total_results > 0) {
            const results2 = data2.results;
            // Cerca nelle risposte un risultato che sia classificato come città
            const cityResult2 = results2.find(result => result.components._type === 'city');
            if (cityResult2) {
                console.log("Il testo inserito è una città:", cityResult2.formatted);
            } else {
                console.log("Il testo inserito non è una città.");
                alert("Inserisci una città di arrivo valida!");
            }
            } else {
            console.log("Nessun risultato trovato per l'input fornito.");
            alert("Inserisci una città di arrivo valida!");
            }
        } catch (error) {
            console.error("Errore nella richiesta API:", error);
        }

        const datapartenza=document.getElementById("data-partenza").value;
        const dataritorno=document.getElementById("data-ritorno").value;
        if (datapartenza>dataritorno) alert("La data di ritorno deve essere successiva alla data di partenza");
    })
})

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



