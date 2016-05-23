<?php
  session_start();

  if (!isset($_SESSION["iduser"]) ) {
    setcookie(nonconnecte,1,time()+4,'/');
    header('location: connexion.php');
  }

  /* === RECUPERATION DES MESSAGES === */
  //connexion à la bdd
  $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
  //Requête pour avoir les messages
  // formulation et execution de la requette
  $result2= pg_prepare($bdd,"query2",'SELECT idmessage, objet, contenu, dateenvoi, etat, idemetteur,idrecepteur, nom, prenom FROM messages, utilisateurs WHERE messages.idemetteur = utilisateurs.iduser AND idrecepteur = $1 ORDER BY dateenvoi DESC FETCH FIRST 5 ROWS ONLY;');
  // recupération du resultat de la requete
  $result2= pg_execute($bdd, "query2",array ($_SESSION["iduser"]));
  //Comptage du nombre de résultats
  $nbresults2=pg_num_rows($result2)	;
  //Récupération des résultats
  $cptNonLu = 0;
  $cptBrouillon = 0;
  for ($i=0; $i < $nbresults2; $i++) {
    $tabres = pg_fetch_array($result2, $i);
    $messages['idmessage'][$i] = $tabres[0];
    $messages['objet'][$i] = $tabres[1];
    $messages['contenu'][$i] = $tabres[2];
    $messages['dateenvoi'][$i] = date('d-m-Y',strtotime($tabres[3]));
    $messages['etat'][$i] = $tabres[4];
    $messages['idemetteur'][$i] = $tabres[5];
    $messages['idrecepteur'][$i] = $tabres[6];
    $messages['nom'][$i] = $tabres[7];
    $messages['prenom'][$i] = $tabres[8];

    if($messages['etat'][$i] == 0){
        $cptNonLu += 1;
    }

    if($messages['etat'][$i] == 1){
        $cptBrouillon += 1;
    }
  }
  //Fermeture de la connexion
  pg_close($bdd);
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
        <link href="../css/messages.css" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
    </head>
    <body>
        <div id="smoke-background">
            <div id="wrap-message">
            </div>
        </div>
    <div id="wrap-container">
        <header>
        <a href="/index.php"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
          <a href="#" class="btn-fieldset btn btn-primary">Mon profil</a>
          <a href="pages/traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
        </header>
        <nav>
        <ul id="wrap-li">
          <li ><a href="/index.php">Accueil</a></li>
          <li ><a href="/pages/presentation.php">Présentation</a></li>
          <li><a href="/pages/Publications.php"> Publications </a></li>
          <li><a href="/pages/evenements.php"> Evénements </a></li>
          <li class="actif"><a href="/pages/messages.php"> Messages </a></li>
          <li><a href="/pages/annuaire.php"> Annuaire </a></li>
          <?php
          if ($_SESSION["statut"] = 1)
            echo "<li><a href=\"/pages/budget.php\"> Budget </a></li>\n"
          ?>
        </ul>
        </nav>
        <div class="wrap-content">
        <div id="left-panel">
            <!-- Début ici -->
            <table class="table" id="table-messages">
                <tr>
                    <th></th>
                    <th>De </th>
                    <th>Objet</th>
                    <th>Reçu le</th>
                </tr>
                <?php
                for ($i=0; $i < $nbresults2; $i++) {
                    if($messages['etat'][$i] == 0){
                        echo "<tr>";
                        echo "\n\t<td><span class='glyphicon glyphicon-record'></span></td>";
                        echo "\n\t<td>".$messages["prenom"][$i]." ".$messages["nom"][$i]."</br></td>";
                        echo "\n\t<td><a style='cursor:pointer;' onclick='request(".$messages["idmessage"][$i].")'>".$messages["objet"][$i]."</a></br></td>";
                        echo "\n\t<td>".$messages["dateenvoi"][$i]."</br></td>";
                        echo "</tr>";
                    }else{
                        echo "<tr>";
                        echo "\n\t<td></td>";
                        echo "\n\t<td>".$messages["prenom"][$i]." ".$messages["nom"][$i]."</td>";
                        echo "\n\t<td><a style='cursor:pointer;' onclick='request(".$messages["idmessage"][$i].")'>".$messages["objet"][$i]."</a></td>";
                        echo "\n\t<td>".$messages["dateenvoi"][$i]."</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
        <div id="right-panel">
            <div id="message-content">
            </div>
            <div id="messages-stats">
                <?php
                echo "<p><strong>".$cptNonLu."</strong> messages non-lu(s)</p>";
                echo "<p><strong>".$cptBrouillon."</strong> brouillons</p>";
                ?>
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
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/squelette.js"></script>
    <script src="../js/messages.js"></script>
    <script src="../js/xhr.js"></script>
    <script src="../js/getMessage.js"></script>
  </body>
</html>
