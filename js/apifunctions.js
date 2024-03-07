//Carica utenti
function caricaUtenti() {
    $.ajax({
        url: 'api/read.php',
        dataType: 'json',
        cache: false,
        success: function(data) {
            //Svuotiamo la tabella prima di caricare i nuovi dati
            $("#tabella").find('tr:not(:has(th))').remove();
            for (var i=0; i<data.length; i++) {
                var row = '<tr><td>' +
    data[i].barcode + '</td><td>' +
    data[i].nome + '</td><td>' +
    data[i].prezzo + '</td><td>' +
    data[i].quantita + '</td><td>' +
    data[i].stato +  // Aggiungi questa parte per visualizzare lo stato
    '<td><button type="button" class="btn btn-danger" onclick="elimina(\'' + data[i].barcode+ '\')">Elimina</button></td>' + 
    '<td><button type="button" class="btn btn-primary" onclick="copiaInFormModifica(\'' + data[i].barcode+ '\', \'' + data[i].nome + '\', \'' + data[i].prezzo + '\', \'' + data[i].quantita + '\')">Modifica</button></td>' + 			
    '</tr>';

                $('#tabella').append(row);
            }
        },
        error: function( jqXhr, textStatus, errorThrown ){
            var data = jqXhr.responseJSON;
            mostraErrore('Errore: ' + data.messaggio);
        }
    });
};

//Elimina utente:
function elimina(barcode) {
    $.ajax({
        url: 'api/delete.php',
        dataType: 'json',
        type: 'delete',
        contentType: 'application/json',
        data: JSON.stringify( { "barcode": barcode } ),
        processData: false,
        success: function(){
            caricaUtenti();
        },
        error: function( jqXhr, textStatus, errorThrown ){
            var data = jqXhr.responseJSON;
            mostraErrore('Errore: ' + data.messaggio);
        }
    });
};

//Aggiungi utente:

function aggiungi() {
    $('#modalAggiungi').modal('hide');

    // Ottenere il valore del radio button selezionato
    var statoSelezionato = $('input[name="stato"]:checked').val();

    $.ajax({
        url: 'api/create.php',
        dataType: 'json',
        type: 'post',
        contentType: 'application/json',
        data: JSON.stringify({
            "barcode": $('#barcode').val(),
            "nome": $('#nome').val(),
            "prezzo": $('#prezzo').val(),
            "quantita": $('#quantita').val(),
            "stato": statoSelezionato  // Utilizza lo stato selezionato
        }),
        processData: false,
        success: function () {
            caricaUtenti();
            $('#creazione_utente').trigger("reset");
        },
        error: function (jqXhr, textStatus, errorThrown) {
            var data = jqXhr.responseJSON;
            mostraErrore('Errore: ' + data.messaggio);
        }
    });
}



function copiaInFormModifica(barcode, nome, prezzo, quantita){
    var m_barcode = $('#barcode_modifica');
    var m_nome = $('#nome_modifica');
    var m_prezzo = $('#prezzo_modifica');
    var m_quantita = $('#quantita_modifica');
    var m_stato = $('#quantita_stato');

    m_barcode.val(barcode);
    m_nome.val(nome);
    m_prezzo.val(prezzo.toString()); // Converti prezzo in stringa
    m_quantita.val(quantita.toString()); // Converti quantita in stringa
    $('#modalModifica').modal('show');
}
function modifica() {
    $('#modalModifica').modal('hide');

    var barcode_modifica = $('#barcode_modifica').val();
    var nome_modifica = $('#nome_modifica').val();
    var prezzo_modifica = $('#prezzo_modifica').val();
    var quantita_modifica = $('#quantita_modifica').val();

    $.ajax({
        url: 'api/update.php',
        dataType: 'json',
        type: 'put',
        contentType: 'application/json',
        data: JSON.stringify({
            "barcode": barcode_modifica,
            "nome": nome_modifica,
            "prezzo": prezzo_modifica,
            "quantita": quantita_modifica
        }),
        processData: false,
        success: function (data, textStatus, jQxhr) {
            caricaUtenti();
            $('#modifica_utente').trigger("reset");
        },
        error: function (jqXhr, textStatus, errorThrown) {
            var data = jqXhr.responseJSON;
            mostraErrore('Errore: ' + data.messaggio);
        }
    });
};

function mostraErrore(descrizione_errore){
    document.getElementById("errore").innerHTML = descrizione_errore;
    $("#alert-errore").fadeTo(2000, 500).slideUp(500, function() {
        $("#alert-errore").slideUp(500);
    });
}

$( document ).ready(function() {
    //All'avvio, carichiamo la tabella:
    caricaUtenti();
    //Nascondiamo l'eventuale alert per errori:
    $("#alert-errore").hide();
});
