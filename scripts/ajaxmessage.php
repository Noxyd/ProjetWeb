<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    //Récupération de l'id du message à afficher
    $idMessage = $_GET['id'];
    /* === RECUPERATION D'UN MESSAGE === */
    //connexion à la bdd
    $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
    // formulation et execution de la requette
    $result2= pg_prepare($bdd,"query",'SELECT idmessage, objet, contenu, dateenvoi, etat, idemetteur,idrecepteur, nom, prenom FROM messages, utilisateurs WHERE messages.idemetteur = utilisateurs.iduser AND idmessage= $1;');
    // recupération du resultat de la requete
    $result= pg_execute($bdd, "query",array ($idMessage));
    //Comptage du nombre de résultats
    $nbresults2=pg_num_rows($result)	;
    //Récupération des résultats
    for ($i=0; $i < $nbresults2; $i++) {
      $tabres = pg_fetch_array($result, $i);
      $messages['idmessage'] = $tabres[0];
      $messages['objet'] = $tabres[1];
      $messages['contenu'] = $tabres[2];
      $messages['dateenvoi'] = date('d-m-Y',strtotime($tabres[3]));
      $messages['etat'] = $tabres[4];
      $messages['idemetteur']= $tabres[5];
      $messages['idrecepteur'] = $tabres[6];
      $messages['nom'] = $tabres[7];
      $messages['prenom'] = $tabres[8];
    }
    //Fermeture de la connexion
    pg_close($bdd);
    //Formattage JSON des données
    $data = '[
        {
        "emetteur": "'.$messages['prenom'].' '.$messages['nom'].'",
        "objet": "'.$messages['objet'].'",
        "contenu": "'.$messages['contenu'].'"
    }]';

    echo $data;
?>
