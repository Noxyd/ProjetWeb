<?php
// Scripts PHP
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";

  if (!isset($_SESSION["iduser"]) ) {
  	setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: connexion.php');
  }

  $bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requete
	$result = pg_prepare($bdd,"query",'SELECT nom, prenom, mail, description, photo, nomeq FROM utilisateurs, equipes WHERE utilisateurs.ideq = equipes.ideq AND utilisateurs.ideq = $1 ORDER BY nom');
	// récupération du résultat de la requete
	$result = pg_execute($bdd, "query",array ($_GET["id"]));
  $nbresults = pg_num_rows($result);
  // On fait une boucle pour afficher tous les utilisateurs de l'équipe
  for($i=1 ; $i <= $nbresults ; $i++){
    $row=pg_fetch_row($result);
    // Stockage des variables extraits de la base dans un tableau à 2 dimensions
    $user["photo"][$i] = $row[4];
    $user["nom"][$i] = $row[0];
    $user["prenom"][$i] = $row[1];
    $user["mail"][$i] = $row[2];
    $user["description"][$i] = $row[3];
    }
    
  $user["equipe"] = $row[5];

  pg_close($bdd);
?>
<!-- Debut HTML -->
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
    <link href="../css/equipe.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="../index.php"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION['prenom']); ?></legend>
          <a href="profil.php" class="btn-fieldset btn btn-primary">Dashboard</a>
          <a href="traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li><a href="../index.php">Accueil</a></li>
          <li><a href="presentation.php">Présentation</a></li>
          <li><a href="publications.php"> Publications </a></li>
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
        <div id="main-panel">
            <?php
            echo"<h2 class=\"inside-panel\">Equipe ".ucfirst($user["equipe"])."</h2>\n";
            ?>
            <div class="sub-pane1">
              <?php
              // On fait une boucle pour afficher tous les utilisateurs de l'équipe
                for($i=1 ; $i <= $nbresults ; $i++){
                    echo "\t<div class=\"wrap-profil\">\n";
                    echo "\t\t\t<div class=\"round-image\">\n";
                    echo "\t\t\t\t<img id=\"profilpic\" src=\"".$user["photo"][$i]."\"/>\n";
                    echo "\t\t\t</div>\n";
                    echo "\t\t\t<div class=\"sub-pane2\">\n";
                    echo "\t\t\t\t<p class=\"panel-text\">Nom : ".ucfirst($user["nom"][$i])."</p>\n";
                    echo "\t\t\t\t<p class=\"panel-text\">Prénom : ".ucfirst($user["prenom"][$i])."</p>\n";
                    echo "\t\t\t\t<p class=\"panel-text\">Adresse mail : ".$user["mail"][$i]."</p>\n";
                    echo "\t\t\t\t<p class=\"panel-text\">Description : ".$user["description"][$i]."</p>\n";
                    echo "\t\t\t</div>\n";
                  echo "\t\t</div>\n";
                }
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
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/squelette.js"></script>
  </body>
</html>
