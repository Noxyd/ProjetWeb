<!-- Scripts PHP -->
<?php
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";

  if (!isset($_SESSION["iduser"]) ) {
  	setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: connexion.php');
  }

  $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requette
	$result= pg_prepare($bdd,"query",'select * from utilisateurs where ideq = $1');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ($_GET["id"]));
  $nbresults = pg_num_rows($result);
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
        <a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION['prenom']); ?></legend>
          <a href="profil.php" class="btn-fieldset btn btn-primary">Mon profil</a>
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
          <li><a href="budget.php"> Budget </a></li>
        </ul>
      </nav>
      <div class="wrap-content">
        <div id="main-panel">
            <h2 class="inside-panel">Equipe</h2>
            <div class="sub-pane1">
              <?php
              // On fait une boucle pour afficher tous les utilisateurs de l'équipe
                for($i=1 ; $i <= $nbresults ; $i++){
                  $row=pg_fetch_row($result);
                    echo "<div class=\"wrap-profil\">";
                    echo "<div class=\"round-image\">";
                    echo "<img id=\"profilpic\" src=\"../images/sam.jpg\"/>";
                    echo "</div>";
                    echo "<div class=\"sub-pane2\">";
                    echo "<p class=\"panel-text\">Nom : ".ucfirst($row[1])."</p>";
                    echo "<p class=\"panel-text\">Prénom : ".ucfirst($row[2])."</p>";
                    echo "<p class=\"panel-text\">Description : ".$row[5]."</p>";
                    echo "<p class=\"panel-text\">Adresse mail : ".$row[3]."</p>";
                    echo "</div>";
                  echo "</div>";
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
