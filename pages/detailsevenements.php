<?php
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";

  //verification de session
  if (!isset($_SESSION["iduser"]) ) {

  	    setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: connexion.php');

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
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="../css/squelette.css" rel="stylesheet">
    <link href="../css/evenements.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour  <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
          <a href="profil.php" class="btn-fieldset btn btn-primary">Dashboard</a>
          <a href="traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li><a href="../index.php">Accueil</a></li>
          <li><a href="presentation.php" >Présentation</a></li>
          <li><a href="publications.php"> Publications </a></li>
          <li class="actif"><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
          <li><a href="budget.php"> Budget </a></li>
        </ul>
      </nav>
      <div class="wrap-content">


        <div id="evenements">
          <?php
              //connexion a la base de donnée
            $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
            //preparation de la requette
            $result = pg_prepare($bdd, "my_query", 'SELECT nomeq,intitule,dateeven,lieu,description FROM evenements,equipes WHERE ideven = $1 and equipes.ideq=evenements.ideq');
            //execution de la requette
            $result = pg_execute($bdd, "my_query",array ($_GET["id"]));

            $row=pg_fetch_row($result);//rendre le resultat sous forme de tableau
            //affichage
            echo "<center>";

            echo "<H2> $row[1]</H2><br>\n";
            echo"<H4> organisé par l'equipe : $row[0]</H4><br>";
            echo "\t\t<u>le:</u> $row[2] <u><br>\n";
            echo "\t\tlieu:</u><b> $row[3]</b><br><br>\n";
            echo "\t\t$row[4]\n";

            echo "\t</center>";


          ?>

        </div>
      </div>




      </div>
      <footer>
          <h4> © BLANCHET / GARCIA / MEHDIOUI / SARMA</h4>
          <p>Tous droits réservés.</p>
      </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/squelette.js"></script>
  </body>
</html>
