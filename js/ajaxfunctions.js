/* === getXMLHttpRequest() ===
 *  Permet de choisir l'objet xhr à créer.
 */
function getXMLHttpRequest(){
    var xhr = null;

    if(window.XMLHttpRequest || window.ActiveXObject){
        if(window.ActiveXObject){
            try{
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            }catch(e){
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Le navigateur ne supporte pas XMLHttpRequest ...");
        return null;
    }
    return xhr;
}

/* === request() ===
 * Le but de ce script AJAX est de pouvoir afficher
 * le contenu d'un message présélectionné sans avoir à recharger la page.
 * Le contenu d'un message sera renvoyé par le serveur au format JSON.
 * Note : l'objet XMLHTTPRequest sera abrégé par xhr.
 */
function request(idM,etatM){
    // Création de l'objet xhr
    var xhr = getXMLHttpRequest();
    /* === Uniquement pour debug === */
    // if(xhr == null){
    //     console.log("xhr null");
    // }else {
    //     console.log("connexion prete");
    // }

    //Test de l'état du xhr
    xhr.onreadystatechange = function() {
        // console.log("status : "+xhr.status);
        // console.log("STATE : "+xhr.readyState);
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
            // console.log("récupération des données"); Uniquement pour debug
            //Récupération des données
            readData(xhr.responseText);
        }
    };
    // Initialisation de la requete xhr
    var methode = "GET",
        target = "/scripts/ajaxmessage.php?id="+idM+"&etatM="+etatM,
        type = true;
    xhr.open(methode,target, type);
    //Envoi de la requete xhr
    xhr.send(null);
}

/* === Récupère et formate les données request() === */
function readData(jsonData){
    // La variable message est un tableau contenant les données transmises par le serveur
    var message = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    var out = "<div id='theMessage' >";   // out contiendra le code HTML qui sera placé dans la page messages.php
    // console.log("longueur : "+message.length);
    out += "<h3 style='color:white;'><center>Détails du message</center></h3>";
    for(var i = 0; i<message.length; i++){
        //On lit chaque variable JSON, et on les intègre dans du code HTML
        out = out+"<p><strong>Envoyé par : </strong>"+message[i].emetteur+"</p>"+
            "<p><strong>Objet : </strong>"+message[i].objet+"</p>"+
            "<p style='min-height:200px;'>"+message[i].contenu+"</p>";
    }
    out +="<button class='btn btn-warning btn-message-close' onclick='closeMsg(idU)'>Fermer</button>";
    out +="</div>";
    // console.log(out); Uniquement pour debug
    //On inclu le code contenu dans out dans le #right-panel du fichier messages.php

    //$("body").addClass("body-fixed");
    document.getElementById("smoke-background").style.display = "block";
    document.getElementById("wrap-message").innerHTML = out;
}

/* === refreshMessages() ===
 * Nous allons ici rafraichir la liste des messages d'un utilisateur.
 */
function refreshMessages(idU){
    // Création de l'objet xhr
    var xhr = getXMLHttpRequest();
    /* === Uniquement pour debug === */
    // if(xhr == null){
    //     console.log("xhr null");
    // }else {
    //     console.log("connexion prete");
    // }

    //Test de l'état du xhr
    xhr.onreadystatechange = function() {
        // console.log("status : "+xhr.status); Uniquement pour debug
        // console.log("STATE : "+xhr.readyState); Uniquement pour debug
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
            // console.log("récupération des données"); Uniquement pour debug
            //Récupération des données
            readDataRefresh(xhr.responseText);
        }
    };
    // Initialisation de la requete xhr
    var methode = "GET",
        target = "/scripts/refreshMessages.php?idU="+idU,
        type = true;
    xhr.open(methode,target, type);
    //Envoi de la requete xhr
    xhr.send(null);
}

/* === Résupère les données de refreshMessages() === */
function readDataRefresh(jsonData){
    // La variable message est un tableau contenant les données transmises par le serveur
    var messages = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    var out = "<tr>";   // out contiendra le code HTML de sortie
    out+="<th></th>";
    out+="<th>De</th>";
    out+="<th>Objet</th>";
    out+="<th>Reçu le</th>";
    out+="</tr>";

    for(var i = 0; i<messages.length; i++){
        //On lit chaque variable JSON, et on les intègre dans du code HTML
        out+='<tr>';
        out+=messages[i].col1;
        out+=messages[i].col2;
        out+=messages[i].col3;
        out+=messages[i].col4;
        out+='</tr>';
    }
    // console.log(out); Uniquement pour debug
    document.getElementById("table-messages").innerHTML = out;
}

/* === refreshCounter() ===
 *  Permet de rafraichir les compteurs de messages
 */
function refreshCounter(idU){
    // Création de l'objet xhr
    var xhr = getXMLHttpRequest();
    /* === Uniquement pour debug === */
    // if(xhr == null){
    //     console.log("xhr null");
    // }else {
    //     console.log("connexion prete");
    // }

    //Test de l'état du xhr
    xhr.onreadystatechange = function() {
        // console.log("status : "+xhr.status); Uniquement pour debug
        // console.log("STATE : "+xhr.readyState); Uniquement pour debug
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
            // console.log("récupération des données"); Uniquement pour debug
            //Récupération des données
            readDataCounterRefresh(xhr.responseText);
        }
    };
    // Initialisation de la requete xhr
    var methode = "GET",
        target = "/scripts/refreshCounterMessages.php?idU="+idU,
        type = true;
    xhr.open(methode,target, type);
    //Envoi de la requete xhr
    xhr.send(null);
}

/* === Récupère les données de refreshCounterMessages() === */
function readDataCounterRefresh(jsonData){
    // La variable message est un tableau contenant les données transmises par le serveur
    var count = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    var out = "";   // out contiendra le code HTML de sortie

    out+="<p><strong>"+count.cptNL+"</strong> message(s) non-lu(s)</p>";

    // console.log(out); Uniquement pour debug
    document.getElementById("messages-stats").innerHTML = out;
}

/* === messagesEnvoyes() ===
 * Liste les messages envoyés par l'utilisateur courant
 */
function messagesEnvoyes(idU){
    // Création de l'objet xhr
    var xhr = getXMLHttpRequest();
    //Test de l'état du xhr
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
            //Récupération des données
            readDataEnvoyes(xhr.responseText);
        }
    };

    // Initialisation de la requete xhr
    var methode = "GET",
        target = "/scripts/sentMessages.php?idU="+idU,
        type = true;
    xhr.open(methode,target, type);
    //Envoi de la requete xhr
    xhr.send(null);
}

/* === Lecture des données de messagesEnvoyes() === */
function readDataEnvoyes(jsonData){
    // La variable message est un tableau contenant les données transmises par le serveur
    try{
        var messages = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    }catch(e){
        var messages = null;
    }
    var out = "<tr>";   // out contiendra le code HTML de sortie
    out+="<th>A</th>";
    out+="<th>Objet</th>";
    out+="<th>Envoyé à</th>";
    out+="</tr>";

    if(messages != null){
        for(var i = 0; i<messages.length; i++){
            //On lit chaque variable JSON, et on les intègre dans du code HTML
            out+='<tr>';
            out+=messages[i].col1;
            out+=messages[i].col2;
            out+=messages[i].col3;
            out+='</tr>';
        }
    } else {
        out+='<tr>';
        out+='<td><center>Pas de messages envoyés</center></td>';
        out+='</tr>';
    }
    // console.log(out); Uniquement pour debug
    document.getElementById("table-messages").innerHTML = out;

}

/* === printSentMails() ===
 * Cette fonction permet de quitter la visualisation d'un message envoyé.
 */
function printSentMails(idM){
    // Création de l'objet xhr
    var xhr = getXMLHttpRequest();
    //Test de l'état du xhr
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
            //Récupération des données
            dataSentMail(xhr.responseText);
        }
    };
    // Initialisation de la requete xhr
    var methode = "GET",
        target = "/scripts/ajaxmessage.php?id="+idM,
        type = true;
    xhr.open(methode,target, type);
    //Envoi de la requete xhr
    xhr.send(null);
}

/* === Récupère et formate les données printSentMails() === */
function dataSentMail(jsonData){
    var message = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    var out = "<div id='theMessage' >";   // out contiendra le code HTML qui sera placé dans la page messages.php
    out += "<h3 style='color:white;'><center>Détails du message</center></h3>"
    for(var i = 0; i<message.length; i++){
        out = out+"<p><strong>Envoyé par : </strong>"+message[i].emetteur+"</p>"+
            "<p><strong>Objet : </strong>"+message[i].objet+"</p>"+
            "<p style='min-height:200px;'>"+message[i].contenu+"</p>";
    }
    out +="<button class='btn btn-warning btn-message-close' onclick='closeSmoke()'>Fermer</button>";
    out +="</div>";

    //$("body").addClass("body-fixed");
    document.getElementById("smoke-background").style.display = "block";
    document.getElementById("wrap-message").innerHTML = out;
}
