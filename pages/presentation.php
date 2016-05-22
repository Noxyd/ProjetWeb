<!-- Scripts PHP -->
<?php
    session_start();
    include "../scripts/calandar.php";
    if (!isset($_SESSION["iduser"]) ) {
        setcookie(nonconnecte,1,time()+4,'/');
        header('location: pages/connexion.php');
    }
    $lipsum = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";
    //Intérrogation BDD pour voir les messages
    $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
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
          <li class="actif"><a href="presentation.php">Présentation</a></li>
          <li><a href="publications.php"> Publications </a></li>
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
          <li><a href="budget.php"> Budget </a></li>
        </ul>
      </nav>
      <div class="wrap-content">
        <div id="left-panel">
          <div id="un" class="left-sub-panel">
            <h2 class="inside-panel">Présentation du projet</h2>
            <p class="panel-text">
              Ce site a été conçu dans l'optique de proposer une plateforme
              collaborative de recherche pour que les chercheurs puissent
              travailler autour d'un projet et ce, même éloigné l'un de l'autre
              géographiquement.
            </p>
          </div>
          <div class="left-sub-pane2">
            <h2 class="inside-panel">Nos partenaires</h2>
            <p class="panel-text">
              <?php echo $lipsum; ?>
            </p>
          </div>
        </div>
        <div id="right-panel">
          <div id="newmessages" >
            <h3 class="right-side-h3" style="border-bottom:none;">Vos messages</h3>
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
                    echo "\n\t<td><span class='glyphicon glyphicon-record'></span></td>";
                else
                    echo "<td></td>";
                echo "\n\t\t\t<td style=\"width:70px;\">".ucfirst($messages['prenom'][$i])." </td>";
                echo "\n\t\t\t<td><a style='cursor:pointer;' onclick='request(".$messages['idmessage'][$i].")'>".$messages['objet'][$i]."</a></td>";
                echo "\n\t\t\t<td style=\"width:80px;\">".date('d/m/Y',$messages['dateenvoi'][$i])."</td>";
                echo "\n\t\t</tr>";
            }
            echo "\n\t</table>\n";
            ?>
            <center><a href="pages/messages.php" class="btn btn-warning">Tous les messages</a></center>
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
