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
	$result = pg_prepare($bdd,"query",'select description, photo from utilisateurs where iduser = $1');
	// récupération du résultat de la requete
	$result = pg_execute($bdd, "query",array ($_SESSION["iduser"]));
  $row = pg_fetch_row($result);

  // Stockage des variables extraites de la base dans des variables internes
  $user["description"] = $row[0];
  $user["photo"] = $row[1];
  // On ferme la connexion à la base
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
    <link href="../css/profil.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="../index.php"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
          <a href="profil.php" class="btn-fieldset btn btn-info">Dashboard</a>
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
            <h2 class="inside-panel">Dashboard</h2>
            <div class="sub-pane1">
              <div class="wrap-profil">
                <div class="round-image">
                  <?php echo "<img id=\"profilpic\" src=\"".$user["photo"]."\"/>\n"; ?>
                </div>
                <div class="identity">
                  <p class="panel-text">Nom : <?php echo ucfirst($_SESSION["nom"]); ?></p>
                  <p class="panel-text">Prénom : <?php echo ucfirst($_SESSION["prenom"]); ?></p>
                  <p class="panel-text">Adresse mail : <?php echo $_SESSION["mail"]; ?></p>
                  <p class="panel-text">Description : <?php echo $user["description"]; ?></p>
                </div>
              </div>
              <?php echo "<a href=\"equipe.php?id=".$_SESSION["ideq"]."\" class=\"btn btn-default\">Mon équipe</a>\n"; ?>
            </div>
            <div class="sub-pane2">
              <table class="table">
                <thead>
                  <tr>
                    <th>Tâche</th>
                    <th>Deadline</th>
                    <th>Etat</th>
                    <th>Valider</th>
                  </tr>
                </thead>
              </table>
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
