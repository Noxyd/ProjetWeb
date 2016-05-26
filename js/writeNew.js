function sendNewMessage(idU){
    // Création de l'objet xhr
    var xhr = getXMLHttpRequest();
    //Récupération du contenu du formulaire
    var destinataire = document.getElementById("destinataire").value,
        objet = document.getElementById("objet").value,
        contenu = document.getElementById("contenu").value;

    console.log(destinataire+" "+objet+" "+contenu);
    //Test de l'état du xhr
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
            //Récupération des données
            testSend(xhr.responseText);
        }
    };
    // Initialisation de la requete xhr
    var methode = "GET",
        target = "/scripts/newmessage.php?id="+idU+"&dest="+destinataire+"&objet="+objet+"&contenu="+contenu,
        type = true;
    xhr.open(methode,target, type);
    //Envoi de la requete xhr
    xhr.send();
}

function testSend(jsonData){
    // La variable message est un tableau contenant les données transmises par le serveur
    var valreturn = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    var out = "";   // out contiendra le code HTML qui sera placé dans la page messages.php

    if(valreturn[0].flag == 1){
        out+="<div class='alert alert-success' role='alert'>Message envoyé avec succès.</div>";
    } else {
        out+="<div class='alert alert-danger' role='alert'>Une erreur s'est produite lors de l'envoi.</div>";
    }
    //On inclu le code contenu dans out dans le #right-panel du fichier messages.php
    document.getElementById("smoke-background-send").style.display = 'none';
    document.getElementById("global-info").innerHTML = out;
}
