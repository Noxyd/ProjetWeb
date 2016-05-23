<?php
  session_start();
  include "scripts/calandar.php";
  //On vérifie que l'utilisateur est passé apr le formulaire de connexion
  if (!isset($_SESSION["iduser"]) ) {
  	header('location: pages/connexion.php');
  }
  //Intérrogation BDD pour voir les publications
  //connexion à la bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
	// formulation et execution de la requette
	$result= pg_prepare($bdd,"query",'SELECT idpub, titre, datepub, contenu, etat, ideq FROM publications WHERE etat = 1 ORDER BY datepub DESC FETCH FIRST 3 ROWS ONLY');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ());
  //Comptage du nombre de résultats
	$nbresults=pg_num_rows($result)	;
  //Récupération des résultats
  for ($i=0; $i < $nbresults; $i++) {
    $tabres = pg_fetch_array($result, $i);
    $publi['idpub'][$i] = $tabres[0];
    $publi['titre'][$i] = $tabres[1];
    $publi['datepub'][$i] = strtotime($tabres[2]);
    $publi['contenu'][$i] = $tabres[3];
    $publi['etat'][$i] = $tabres[4];
    $publi['ideq'][$i] = $tabres[5];
  }

  //Intérrogation BDD pour voir les messages
  // formulation et execution de la requette
  $result2= pg_prepare($bdd,"query2",'SELECT idmessage, objet, contenu, dateenvoi, etat, idemetteur,idrecepteur, nom, prenom FROM messages, utilisateurs WHERE messages.idemetteur = utilisateurs.iduser AND idrecepteur = $1 ORDER BY dateenvoi DESC FETCH FIRST 5 ROWS ONLY;');
  // recupération du resultat de la requete
  $result2= pg_execute($bdd, "query2",array ($_SESSION["iduser"]));
  //Comptage du nombre de résultats
  $nbresults2=pg_num_rows($result2)	;
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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/squelette.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="smoke-background">
        <div id="wrap-message">
        </div>
    </div>
    <div id="wrap-container">
      <header>
        <a href="/index.php"><img id="logo" src="images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
          <a href="pages/profil.php" class="btn-fieldset btn btn-primary">Mon profil</a>
          <a href="pages/traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li class="actif"><a href="index.php">Accueil</a></li>
          <li ><a href="pages/presentation.php">Présentation</a></li>
          <li><a href="pages/publications.php"> Publications </a></li>
          <li><a href="pages/evenements.php"> Evénements </a></li>
          <li><a href="pages/messages.php"> Messages </a></li>
          <li><a href="pages/annuaire.php"> Annuaire </a></li>
          <?php
          if ($_SESSION["statut"] = 1)
            echo "<li><a href=\"pages/budget.php\"> Budget </a></li>\n"
          ?>
        </ul>
      </nav>
      <div class="wrap-content">
        <div id="left-panel">
          <?php
          for ($i=0; $i < $nbresults; $i++) {
            echo "<div id=\"un\" class=\"left-sub-panel\">";
            echo "\n\t\t<a href=\"#\" class=\"inside-panel-link\"><h2 class=\"inside-panel\">".$publi['titre'][$i]."</h2></a>";
            echo "\n\t\t<p class=\"inside-panel horodatage\"><i>publié le ".date('d/m/Y',$publi['datepub'][$i])."</i></p>";
            echo "\n\t\t<p class=\"panel-text\">".substr($publi['contenu'][$i],0,120)."<a href=\"pages/affichagepub.php?id=".$publi['idpub'][$i]."\">...</a></p>";
            echo "\n\t\t<a href=\"pages/affichagepub.php?id=".$publi['idpub'][$i]."\" class=\"inside-panel btn-lire-plus\">Lire plus</a>";
            echo "\n\t</div>";
          }
          ?>
        </div>
        <div id="right-panel">
            <div id="newmessages" >
                <h3 class="right-side-h3" style="border-bottom:none;"><a href="pages/messages.php">Vos messages</a><small><a onclick="closeMsg()" style="margin-left:30px;cursor:pointer;color:inherit;"><span class="glyphicon glyphicon-refresh" style="cursor:pointer;"></span> Rafraichir</a></small></h3>
                <table id="table-messages" class="table table-striped">
                    <!-- Rempli par fonction AJAX -->
                </table>
            <!-- <h3 class="right-side-h3" style="border-bottom:none;">Vos messages</h3>
            <?php
            echo "<table class=\"table \">";
            echo "\n\t\t<tr>";
            echo "\n\t\t\t<th></td>";
            echo "\n\t\t\t<th style=\"width:70px;\">De</td>";
            echo "\n\t\t\t<th>Objet</td>";
            echo "\n\t\t\t<th style=\"width:80px;\">Reçu le</td>";
            echo "\n\t\t</tr>";
            for ($i=0; $i < $nbresults2; $i++) {
                echo "\n\t\t<tr>";
                if($messages['etat'][$i] == 0)
                    //Le message n'a pas été lu
                    echo "\n\t<td><span class='glyphicon glyphicon-record'></span></td>";
                else
                    echo "<td></td>";
                echo "\n\t\t\t<td style=\"width:70px;\">".ucfirst($messages['prenom'][$i])." </td>";
                echo "\n\t\t\t<td><a style='cursor:pointer;' onclick='request(".$messages['idmessage'][$i].",".$messages['etat'][$i].")'>".$messages['objet'][$i]."</a></td>";
                echo "\n\t\t\t<td style=\"width:80px;\">".date('d/m/Y',$messages['dateenvoi'][$i])."</td>";
                echo "\n\t\t</tr>";
            }
            echo "\n\t</table>\n";
            ?>
            <center><a href="pages/messages.php" class="btn btn-warning">Tous les messages</a></center> -->
          </div>
          <div id="calendrier">
            <h3 class="right-side-h3">Calendrier</h3>
            <p><center><strong><?php echo date('F Y'); ?></strong></center></p>
            <?php
                $actualMonth = date('m');
                calculateDays($actualMonth);
            ?>
          </div>

        </div>
      </div>
      <footer>

      </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/squelette.js"></script>
    <script src="/js/messages.js"></script>
    <script src="/js/xhr.js"></script>
    <script src="/js/getMessage.js"></script>
    <script src="/js/refreshMessages.js"></script>
    <?php
        echo "<script>refreshMessages(".$_SESSION['iduser'].")</script>";
        echo "\n<script type='text/javascript'>";
        echo "\nfunction closeMsg(){";
        echo "\n$('body').removeClass('body-fixed');";
        echo "\ndocument.getElementById('smoke-background').style.display = 'none';";
        echo "\nrefreshMessages(".$_SESSION['iduser'].");";
        echo "\n}";
        echo "\n</script>\n";
    ?>
  </body>
</html>
