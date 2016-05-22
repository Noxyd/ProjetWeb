/* Le but de ce script AJAX est de pouvoir afficher
 * le contenu d'un message présélectionné sans avoir à recharger la page.
 * Le contenu d'un message sera renvoyé par le serveur au format JSON.
 * Note : l'objet XMLHTTPRequest sera abrégé par xhr.
 */
function request(idM){
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
            readData(xhr.responseText);
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

function readData(jsonData){
    // La variable message est un tableau contenant les données transmises par le serveur
    var message = JSON.parse(jsonData); //JSON.parse pour lire les données formattées en JSON
    var out = "<div id='theMessage' >";   // out contiendra le code HTML qui sera placé dans la page messages.php
    // console.log("longueur : "+message.length);
    out += "<h3 style='color:white;'><center>Détails du message</center></h3>"
    for(var i = 0; i<message.length; i++){
        //On lit chaque variable JSON, et on les intègre dans du code HTML
        out = out+"<p><strong>Envoyé par : </strong>"+message[i].emetteur+"</p>"+
            "<p><strong>Objet : </strong>"+message[i].objet+"</p>"+
            "<p style='min-height:200px;'>"+message[i].contenu+"</p>";
    }
    out +="<button class='btn btn-warning btn-message-close' onclick='closeMsg()'>Fermer</button>";
    out +="</div>";
    // console.log(out); Uniquement pour debug
    //On inclu le code contenu dans out dans le #right-panel du fichier messages.php
    // $("body").css({
    //     "position":"fixed",
    //     "margin":"auto",
    //     "left":0,
    //     "right":0
    // });
    $("body").addClass("body-fixed");
    document.getElementById("smoke-background").style.display = "block";
    document.getElementById("wrap-message").innerHTML = out;
}
