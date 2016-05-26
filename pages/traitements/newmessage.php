<?php
    session_start();
    // Récupération des variables POST
    $iduser = $_SESSION['iduser'];
    $destinataire = $_POST['destinataire'];
    $objet = htmlentities($_POST['objet']);
    $contenu = htmlentities($_POST['contenu']);
    // Génération de la date
    $dateAjd = date("Y-m-d H:i:s");
    /* === Envoi d'un message === */
    //connexion à la bdd
    $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
    // formulation de la requete
    $result2= pg_prepare($bdd,"query","INSERT INTO messages(objet, contenu, dateenvoi, etat, idemetteur, idrecepteur) VALUES($1,$2,$3,0,$4,$5);");
    // Execution de la requete d'envoiz
    $result= pg_execute($bdd, "query",array ($objet,$contenu, $dateAjd, $iduser, $destinataire));

    /* === Retour du résultat de la requete === */
    if($result != FALSE){
        //Succès de la requete
        setcookie('flag-success','1',time()+3,'/');
        header('location: ../messages.php');
    }else {
        //Echec de la requete
        setcookie('flag-error','1',time()+3,'/');
        header('location: ../messages.php');
    }
?>
