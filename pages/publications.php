<?php
    session_start();
    include "../scripts/calandar.php";

    if (!isset($_SESSION["iduser"]) ) {
        setcookie('nonconnecte',1,time()+4,'/');
        header('location: pages/connexion.php');
    }
    // La page tiens compte
    if (!isset($_GET['type']) ) {
        header('location: publications.php?type=2');
    }
    $type = $_GET['type'];
    // connection à la base de données:
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
    // RECHERCHE Publication :
    switch($type){
        case 1 :
            // formulation et execution de la requette
    	    $result= pg_prepare($bdd,"query","SELECT idpub,titre,datepub,contenu,etat,nomeq,publications.ideq from publications,equipes where publications.ideq=equipes.ideq and publications.ideq=$1 ORDER BY datepub DESC;");
            $result = pg_execute($bdd, "query",array($_SESSION['ideq']));
            break;

        case 2 :
            $result= pg_prepare($bdd,"query","SELECT idpub,titre,datepub,contenu,etat,nomeq,publications.ideq from publications,equipes where etat = 1 AND publications.ideq=equipes.ideq ORDER BY datepub DESC; ");
            $result = pg_execute($bdd, "query",array());
            break;
    }

    // recupération du resultat de la requete
    if($result == false){
        echo 'ERREUR';
    }

    //Comptage du nombre de résultats
	$nbresults=pg_num_rows($result)	;

  //Récupération des résultats
  for ($i=0; $i < $nbresults; $i++) {
    $tabres = pg_fetch_array($result, $i);
    $publi['idpub'][$i] = $tabres[0];
    $publi['titre'][$i] = $tabres[1];
    $publi['datepub'][$i] = date('d/m/Y à H:i',strtotime($tabres[2]));
    $publi['contenu'][$i] = $tabres[3];
    $publi['etat'][$i] = $tabres[4];
    $publi['nomeq'][$i] = $tabres[5];
    $publi['ideq'][$i] = $tabres[6];
  }

// RECHERCHE nombre Publication :
$result2= pg_query($bdd,"SELECT *FROM publications WHERE etat = 1 ");
$nbre=pg_num_rows($result2);

// Dernière publication postée:
$result3= pg_query($bdd,'SELECT titre FROM publications WHERE etat = 1 ORDER BY datepub DESC FETCH FIRST 1 ROWS ONLY');
$row=pg_fetch_row($result3);

// Date du prochain évènements:
$result4=pg_query($bdd,'SELECT dateeven FROM Evenements ORDER BY dateeven DESC FETCH FIRST 1 ROWS ONLY');
$row2=pg_fetch_row($result4);

pg_close($bdd);
?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ScienceHUB : Plateforme collaborative de recherche</title>

    <!-- Bootstrap-->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="../css/squelette.css" rel="stylesheet">
    <link href="../css/Publications.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION['prenom']); ?></legend>
          <a href="../pages/profil.php" class="btn-fieldset btn btn-primary">Dashboard</a>
          <a href="../pages/traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li ><a href="../index.php">Accueil</a></li>
          <li ><a href="presentation.php">Présentation</a></li>
          <li class="actif"><a href="publications.php"> Publications </a></li>
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
            <?php
          if ($_SESSION["statut"] == 1)
            echo "<li><a href=\"budget.php\"> Budget </a></li>\n"
          ?>
          </ul>
      </nav>
        <div class="wrap-content">
            <?php
            switch($type){
                case 1 :
                    echo '<h3 style="margin-bottom:30px;">Mes publications</h3>';
                    break;
                case 2 :
                    echo '<h3 style="margin-bottom:30px;">Toutes les publications</h3>';
                    break;
            }
            ?>
            <div id="left-panel">
            <?php

            if (isset($_COOKIE["good1"]))
                echo " <div class=\"alert alert-success\" role=\"alert\"> Votre etat a changé avec succés</div>";
            if (isset($_COOKIE["echec2"]))
                echo " <div class= \"alert alert-danger\" role=\"alert\">Echec, veuillez tenter à nouveau</div>";

            for ($i=0; $i < $nbresults; $i++) {
                echo "<div id=\"un\" class=\"left-sub-panel\">";

                echo "\n\t\t<h2 class=\"inside-panel\">".$publi['titre'][$i]."</h2>";
                if ($publi['etat'][$i] == 1){
                    echo "\n\t\t<p class=\"inside-panel horodatage\"><i>Publié par ".$publi['nomeq'][$i].", le ".$publi['datepub'][$i]."</i></p>";
                }else{
                    echo "\n\t\t<p class=\"inside-panel horodatage\"><i>Publié par ".$publi['nomeq'][$i].", le ".$publi['datepub'][$i]." <span style='color:red'>(Archivé)</span></i></p>";
                }
                echo "\n\t\t<p class=\"panel-text\">".htmlentities($publi['contenu'][$i])."<a href=\"#\">...</a></p>";
                echo "\n\t\t<a href=\"affichagepub.php?id=".$publi['idpub'][$i]."\" class=\"inside-panel btn-lire-plus\">Lire plus</a>";
                if($publi['etat'][$i] == 1 && $publi['ideq'][$i] == $_SESSION['ideq'])
                    echo "\n\t\t<a href=\"traitements/changement_etat_pub.php?idpub=".$publi['idpub'][$i]."&"."idetat=".$publi['etat'][$i]. "\"class=\"btn-fieldset btn btn-primary\">Archiver</a>";
                else if($publi['etat'][$i] == 0 && $publi['ideq'][$i] == $_SESSION['ideq'])
                    echo "\n\t\t<a href=\"traitements/changement_etat_pub.php?idpub=".$publi['idpub'][$i]."&"."idetat=".$publi['etat'][$i]. "\"class=\"btn-fieldset btn btn-primary\">Publier</a>";
                echo "\n\t</div>";
            }

            if ($nbresults == 0) {
                echo "<p><b>Vous n'avez pas de publications.</b></p>";
            }

            ?>
            </div>
            <div id="right-panel">

                <div id="newmessages">
                    <h3 class="right-side-h3">Les statistiques</h3>
                    <div id="stats">
                    <?php
                    echo "\n\t\t<p> <b>Nombre de publications : </b>".$nbre."</p>";
                    echo "\n\t\t<p> <b>Dernière publication : </b><br>".$row[0]."</p>";
                    ?>
                    </div>
                </div>
                <center>
                <div id="fieldset-right" >
                    <div id="fieldset-right" >
                        <a  href="Articles.php" class="btn btn-primary" style="margin:auto;width:300px;">Rediger un article</a>
                    </div>
                    <?php
                        switch($type){
                            case 1 :
                                echo '<a href="publications.php?type=2" class="btn btn-warning" style="margin:auto;width:300px;">Voir toutes les publications</a>';
                                break;
                            case 2 :
                                echo "<a href=\"publications.php?type=1\" class=\"btn btn-warning\" style=\"margin:auto;width:300px;\">Voir mes publications</a>";
                                break;
                         }
                    ?>
                </div>
                </center>
            </div>
        </div>
        <footer>
            <h4> © BLANCHET / GARCIA / MEHDIOUI / SARMA</h4>
            <p>Tous droits réservés.</p>
        </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/squelette.js"></script>
  </body>
</html>
