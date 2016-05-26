<?php
  session_start();
  //On vérifie que l'utilisateur est passé apr le formulaire de connexion
  if (!isset($_SESSION["iduser"]) ) {
  	header('location: pages/connexion.php');
  }
  //Intérrogation de la base de données
  //connexion à la bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
	// formulation et execution de la requette
	$result= pg_prepare($bdd,"query",'SELECT idpub, titre, datepub, contenu, etat, ideq FROM publications WHERE etat = 1 AND idpub = $1');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ($_GET['id']));
  //Comptage du nombre de résultats
	$nbresults=pg_num_rows($result)	;
  //Récupération des résultats
  for ($i=0; $i < $nbresults; $i++) {
    $tabres = pg_fetch_array($result, $i);
    $publi['idpub'] = $tabres[0];
    $publi['titre'] = $tabres[1];
    $publi['datepub'] = $tabres[2];
    $publi['contenu'] = $tabres[3];
    $publi['etat'] = $tabres[4];
    $publi['ideq'] = $tabres[5];
  }

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
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="#"><img id="logo" src="images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION['prenom']); ?></legend>
          <a href="pages.profil.php" class="btn-fieldset btn btn-primary">Mon profil</a>
          <a href="pages/traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li class="actif"><a href="../index.php">Accueil</a></li>
          <li ><a href="presentation.php">Présentation</a></li>
          <li><a href="Publications.php"> Publications </a></li>
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
          <?php
          if ($_SESSION["statut"] = 1)
            echo "<li><a href=\"/pages/budget.php\"> Budget </a></li>\n"
          ?>
        </ul>
      </nav>
      <div class="wrap-content">
        <div id="left-panel">
          <?php
            echo "<div id=\"un\" class=\"left-sub-panel\">";
            echo "\n\t\t<a href=\"#\" class=\"inside-panel-link\"><h2 class=\"inside-panel\">".$publi['titre']."</h2></a>";
            echo "\n\t\t<p class=\"inside-panel horodatage\"><i>publié ".$publi['datepub']."</i></p>";
            echo "\n\t\t<p class=\"panel-text\">".$publi['contenu']."</p>";
            echo "\n\t\t<a href=\"pages/affichagepub.php?id=".$publi['idpub']."\" class=\"inside-panel btn-lire-plus\">Lire plus</a>";
            echo "\n\t</div>";
          ?>
        </div>
        <div id="right-panel">
          <div id="newmessages" >
            <h3 class="right-side-h3">Vos messages</h3>
          </div>
          <div id="calendrier">
            <h3 class="right-side-h3">Calendrier</h3>
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
  </body>
</html>
