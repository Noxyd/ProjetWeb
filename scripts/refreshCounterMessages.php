<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    /* === RECUPERATION D'UN MESSAGE === */
    //connexion à la bdd
    $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
    //Intérrogation BDD pour voir les messages
    // formulation et execution de la requette
    $result2= pg_prepare($bdd,"query2",'SELECT etat FROM messages WHERE idrecepteur = $1 ORDER BY dateenvoi;');
    // recupération du resultat de la requete
    $result2= pg_execute($bdd, "query2",array ($_GET['idU']));
    //Comptage du nombre de résultats
    $nbresults2=pg_num_rows($result2);
    //Récupération des résultats
    $cptNonLu=0;
    $cptBrouillons=0;
    for ($i=0; $i < $nbresults2; $i++) {
        $tabres = pg_fetch_array($result2, $i);
        if($tabres[0] == 0)
            $cptNonLu+=1;
        elseif ($tabres[0] == 1)
            $cptBrouillons+=1;
    }
    //Fermeture de la connexion
    pg_close($bdd);
    //Formattage JSON des données
    $data = '
        {
            "cptNL": "'.$cptNonLu.'",
            "cptBR": "'.$cptBrouillons.'"
        }
    ';
    //Envoi des données
    echo $data;
?>
