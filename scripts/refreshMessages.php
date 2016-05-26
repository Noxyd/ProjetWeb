<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    /* === RECUPERATION D'UN MESSAGE === */
    //connexion à la bdd
    $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
    //Intérrogation BDD pour voir les messages
    // formulation et execution de la requette
    $result2= pg_prepare($bdd,"query2",'SELECT idmessage, objet, contenu, dateenvoi, etat, idemetteur,idrecepteur, nom, prenom FROM messages, utilisateurs WHERE messages.idemetteur = utilisateurs.iduser AND idrecepteur = $1 ORDER BY dateenvoi DESC FETCH FIRST 5 ROWS ONLY;');
    // recupération du resultat de la requete
    $result2= pg_execute($bdd, "query2",array ($_GET['idU']));
    //Comptage du nombre de résultats
    $nbresults2=pg_num_rows($result2);
    //Récupération des résultats
    for ($i=0; $i < $nbresults2; $i++) {
      $tabres = pg_fetch_array($result2, $i);
      $messages['idmessage'][$i] = $tabres[0];
      $messages['objet'][$i] = $tabres[1];
      $messages['contenu'][$i] = $tabres[2];
      $messages['dateenvoi'][$i] = strtotime($tabres[3]);
      $messages['etat'][$i] = $tabres[4];
      $messages['idemetteur'][$i] = $tabres[5];
      $messages['idrecepteur'][$i] = $tabres[6];
      $messages['nom'][$i] = $tabres[7];
      $messages['prenom'][$i] = $tabres[8];
    }
    //Fermeture de la connexion
    pg_close($bdd);
    //Formattage JSON des données
    $data = "[";
    for ($i=0; $i < $nbresults2; $i++) {
        if($messages['etat'][$i] == 0){
            $data .= '
                {
                    "col1": "<td><span class=\'glyphicon glyphicon-record\'></span></td>",
                    "col2": "<td>'.$messages["prenom"][$i].' '.$messages["nom"][$i].'</td>",
                    "col3": "<td><a style=\'cursor:pointer;\' onclick=\'request('.$messages["idmessage"][$i].','.$messages["etat"][$i].')\'>'.$messages["objet"][$i].'</a></td>",
                    "col4": "<td>'.date('d-m-Y H:m',$messages["dateenvoi"][$i]).'</td>"

                }
                ';
        }else{
            $data .= '
                {
                    "col1": "<td></td>",
                    "col2": "<td>'.$messages["prenom"][$i].' '.$messages["nom"][$i].'</td>",
                    "col3": "<td><a style=\'cursor:pointer;\' onclick=\'request('.$messages["idmessage"][$i].','.$messages["etat"][$i].')\'>'.$messages["objet"][$i].'</a></td>",
                    "col4": "<td>'.date('d-m-Y',$messages["dateenvoi"][$i]).'</td>"
                }
                ';
        }
        if($i<$nbresults2-1)
            $data .= ',';
    }
    $data .= "]";
    //Envoi des données
    echo $data;
?>
