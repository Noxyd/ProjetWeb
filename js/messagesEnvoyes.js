/* Nous allons ici rafraichir la liste des messages d'un utilisateur.
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
