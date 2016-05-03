<?php
  session_start();
  if (!isset($_SESSION["idusers"]) ) {
  	setcookie(nonconnecte,1,time()+4);
  	    header('location: pages/connexion.php');

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
          <legend>Bonjour <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
          <a href="#" class="btn-fieldset btn btn-primary">Mon profil</a>
          <a href="pages/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <center>
        <ul id="wrap-li">
          <li><a href="#" class="actif">Accueil</a></li>
          <li><a href="#" ><strong>Présentation</strong></a></li>
          <li><a href="#"><strong>Publications</strong></a></li>
          <li><a href="#"><strong>Evénements</strong></a></li>
          <li><a href="#"><strong>Messages</strong></a></li>
          <li><a href="#"><strong>Annuaire</strong></a></li>
          <li><a href="#"><strong>Budget</strong></a></li>
        </ul>
        </center>
      </nav>
      <div id="wrap-content">
        <div id="left-panel">
          <div class="left-sub-panel">
            <a href="#" class="inside-panel-link"><h2 class="inside-panel">Texte H2</h2></a>
            <p class="inside-panel horodatage"><i>publié le 17.03.16 à 14h00</i></p>
            <p class="panel-text">
              Accenderat super his incitatum propositum ad nocendum aliqua mulier vilis,
              quae ad palatium ut poposcerat intromissa insidias ei latenter obtendi prodiderat a
              militibus obscurissimis. quam Constantina exultans ut in tuto iam locata mariti salute
              muneratam vehiculoque inpositam per regiae ianuas emisit in publicum, ut his inlecebris
              alios quoque ad indicanda proliceret paria vel maiora.
            </p>
            <a href="#" class="inside-panel btn-lire-plus">Lire plus</a>
          </div>
          <div class="left-sub-panel">
            <a href="#" class="inside-panel-link"><h2 class="inside-panel">Texte H2</h2></a>
            <p class="inside-panel horodatage"><i>publié le 17.03.16 à 14h00</i></p>
            <p class="panel-text">
              Accenderat super his incitatum propositum ad nocendum aliqua mulier vilis,
              quae ad palatium ut poposcerat intromissa insidias ei latenter obtendi prodiderat a
              militibus obscurissimis. quam Constantina exultans ut in tuto iam locata mariti salute
              muneratam vehiculoque inpositam per regiae ianuas emisit in publicum, ut his inlecebris
              alios quoque ad indicanda proliceret paria vel maiora.
            </p>
            <a href="#" class="inside-panel btn-lire-plus">Lire plus</a>
          </div>
          <div class="left-sub-panel" style="margin-bottom:20px;">
            <a href="#" class="inside-panel-link"><h2 class="inside-panel">Texte H2</h2></a>
            <p class="inside-panel horodatage"><i>publié le 17.03.16 à 14h00</i></p>
            <p class="panel-text">
              Accenderat super his incitatum propositum ad nocendum aliqua mulier vilis,
              quae ad palatium ut poposcerat intromissa insidias ei latenter obtendi prodiderat a
              militibus obscurissimis. quam Constantina exultans ut in tuto iam locata mariti salute
              muneratam vehiculoque inpositam per regiae ianuas emisit in publicum, ut his inlecebris
              alios quoque ad indicanda proliceret paria vel maiora.
            </p>
            <a href="#" class="inside-panel btn-lire-plus">Lire plus</a>
          </div>
          <a href="publications.php" style="float:right;" class="btn btn-warning"><u><b>Voir plus</b></u></a>
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
  </body>
</html>
