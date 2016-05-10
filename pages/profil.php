<?php
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";

  /* === A décommenter dès que possible ===
  if (!isset($_SESSION["idusers"]) ) {
  	setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: pages/connexion.php');

  }*/
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
    <link href="../css/profil.css" rel="stylesheet">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour Machin</legend>
          <a href="../pages/profil.php" class="btn-fieldset btn btn-primary">Mon profil</a>
          <a href="pages/traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li><a href="#">Accueil</a></li>
          <li><a href="../pages/presentation.php">Présentation</a></li>
          <li><a href="#"> Publications </a></li>
          <li><a href="#"> Evénements </a></li>
          <li><a href="#"> Messages </a></li>
          <li><a href="#"> Annuaire </a></li>
          <li><a href="#"> Budget </a></li>
        </ul>
      </nav>
      <div class="wrap-content">
        <div id="main-panel">
            <h2 class="inside-panel">Profil utilisateur</h2>
            <div class="sub-pane1">
              <div class="wrap-profil">
                <div class="round-image">
                  <img id="profilpic" src="../images/sam.jpg"/>
                </div>
                <div class="sub-pane2">
                  <p class="panel-text">Nom :</p>
                  <p class="panel-text">Prénom :</p>
                  <p class="panel-text">Labo :</p>
                  <p class="panel-text">Adresse mail :</p>
                </div>
              </div>
              <a href="../pages/equipe.php" class="btn btn-default">Mon équipe</a>
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
