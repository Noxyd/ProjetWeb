<!-- Scripts PHP -->
<?php
    session_start();
    include "../scripts/calandar.php";
    if (!isset($_SESSION["iduser"]) ) {
        setcookie(nonconnecte,1,time()+4,'/');
        header('location: pages/connexion.php');
    }
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
    <link href="../css/presentation.css" rel="stylesheet">
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
          <li class="actif"><a href="presentation.php">Présentation</a></li>
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
        <div id="left-panel">
          <div id="un" class="left-sub-panel">
            <h2 class="inside-panel">Présentation du site</h2>
            <p class="panel-text">
              Ce site a été conçu dans l'optique de proposer une plateforme
              collaborative de recherche pour que les chercheurs puissent
              travailler autour d'un projet et ce, même éloigné l'un de l'autre
              géographiquement.<br><br>
              Site web réalisé par Florian BLANCHET, Samuel GARCIA, Nadjim MEHDIOUI et Saidharan SARMA dans le cadre du projet WEB - PHP - BDD en L3 STRI.
            </p>
          </div>
          <div class="left-sub-pane2">
            <h2 class="inside-panel">Nos partenaires</h2>
            <p class="panel-part">
              <a href="http://www.univ-tlse3.fr/"><img src="../images/logo/ups.jpg" width="200px" height="auto"></a>
              <a href="http://upssitech.ups-tlse.fr/"><img src="../images/logo/upssitech.png" width="200px" height="auto"></a>
              <a href="http://www.stri.ups-tlse.fr/"><img src="../images/logo/stri.jpg" width="200px" height="auto"></a>
              <a href="http://www.irit.fr"><img src="../images/logo/irit.jpg" width="200px" height="auto"></a>
              <a href="http://www.cnes.fr"><img src="../images/logo/cnes.png" width="150px" height="auto" class="cnes"></a>
              <a href="http://www.cnrs.fr"><img src="../images/logo/cnrs.png" width="150px" height="auto" class="cnrs"></a>
            </p>
          </div>
        </div>
        <div id="right-panel">
          <div id="calendrier">
            <h3 class="right-side-h3">Calendrier</h3>
            <?php
                $tabMois = array(
                    '01' => 'Janvier',
                    '02' => 'Février',
                    '03' => 'Mars',
                    '04' => 'Avril',
                    '05' => 'Mai',
                    '06' => 'Juin',
                    '07' => 'Juillet',
                    '08' => 'Aout',
                    '09' => 'Septembre',
                    '10' => 'Octobre',
                    '11' => 'Novembre',
                    '12' => 'Décembre',
                );
                $actualMonthNb = date('m');
                $actualMonthLetters = $tabMois[$actualMonthNb];
                echo "<p><center><strong>".$actualMonthLetters." ".date('Y')."</strong></center></p>";
                calculateDays($actualMonthNb);
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
    <script type="text/javascript">
        function closeMsg(){
            document.getElementById("smoke-background").style.display = "none";
        }
    </script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/squelette.js"></script>
    <script src="/js/messages.js"></script>
    <script src="/js/xhr.js"></script>
    <script src="/js/getMessage.js"></script>
  </body>
</html>
