<?php
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";

  
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
    <link href="../css/evenement.css" rel="stylesheet">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour  <?php echo $_SESSION["prenom"]; ?></legend>
          <a href="profil.php" class="btn-fieldset btn btn-primary">Mon profil</a>
          <a href="traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li class="actif"><a href="../index.php">Accueil</a></li>
          <li><a href="presentation.php" >Présentation</a></li>
          <li><a href="#"> Publications </a></li>
          <li><a href="evenement.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="#"> Annuaire </a></li>
          <li><a href="#"> Budget </a></li>
        </ul>
      </nav>
      <div class="wrap-content">

       
      <div id="evenement">
        <?php
          $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

             $result = pg_prepare($bdd, "my_query", 'SELECT * FROM evenements WHERE ideven = $1 ');
              $result = pg_execute($bdd, "my_query",array ($_GET["id"]));

              $row=pg_fetch_row($result);
              echo "<u><H2> $row[1]</H2></u><br>";
              echo "<u>le:</u> $row[2] <u>lieu:</u> $row[3]<br><br> $row[4]";
          

        ?>










      </div></div>
    
      
      

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
