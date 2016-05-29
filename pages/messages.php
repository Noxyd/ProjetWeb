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
  $result2= pg_execute($bdd, "query2",array($_SESSION["iduser"]));
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
    // Récupération des identifiants des utilisateurs
    $result3 = pg_prepare($bdd,"queryUtils",'SELECT iduser, mail FROM utilisateurs');
    $result3 = pg_execute($bdd, "queryUtils",array());
    $nbresults3 = pg_num_rows($result3);
    for ($i=0; $i < $nbresults3; $i++) {
        $tabres = pg_fetch_array($result3, $i);
        $util['id'][$i] = $tabres[0];
        $util['mail'][$i] = $tabres[1];
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
        <title>ScienceHUB</title>

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
        <div id="smoke-background" class="smoke">
            <div id="wrap-message" class="smoke-child">
            </div>
        </div>
        <div id="smoke-background-send" class="smoke">
            <div id="wrap-new-message" class="smoke-child">
                <h3 style="padding:5px;color:white;"><center>Nouveau message</center></h3>
                <form method="post" action="traitements/newmessage.php" onsubmit="return checkMailData()">
                    <table id="form-send" style="color:black;">
                        <tr>
                            <td>Destinataire : </td>
                            <td style='color:black;'>
                                <select name='destinataire'>
                                    <?php
                                    for ($i=0; $i < $nbresults3; $i++) {
                                        echo "<option value='".$util['id'][$i]."'>".$util['mail'][$i]."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Objet :</td>
                            <td><input type="text" name="objet"/></td>
                        </tr>
                        <tr>
                            <td>Contenu :</td>
                            <td><textarea id="textarea-message" rows="7" name="contenu"></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input style="width:220px; color:white;" class="btn btn-danger" type="cancel" value="Annuler" onclick="closeNewMsg()"/></td>
                                        <td><input id="btn-envoyer" style="width:220px; color:white;" class="btn btn-warning" type="submit" value="Envoyer" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div id="wrap-container">
            <header>
            <a href="/index.php"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
            <fieldset id="fieldset-header" >
              <legend>Bonjour <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
              <a href="profil.php" class="btn-fieldset btn btn-primary">Dashboard</a>
              <a href="traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
            </fieldset>
            </header>
            <nav>
            <ul id="wrap-li">
              <li ><a href="../index.php">Accueil</a></li>
              <li ><a href="presentation.php">Présentation</a></li>
              <li><a href="publications.php"> Publications </a></li>
              <li><a href="evenements.php"> Evénements </a></li>
              <li class="actif"><a href="messages.php"> Messages </a></li>
              <li><a href="annuaire.php"> Annuaire </a></li>
              <?php
              if ($_SESSION["statut"] == 1)
                echo "<li><a href=\"budget.php\"> Budget </a></li>\n"
              ?>
            </ul>
            </nav>
            <div class="wrap-content">
                <div id="global-info">
                    <?php
                    if(isset($_COOKIE['flag-success']))
                        echo "<div class='alert alert-success' role='alert'>Message envoyé avec succès.</div>";
                    if(isset($_COOKIE['flag-error']))
                        echo "<div class='alert alert-danger' role='alert'>Une erreur s'est produite lors de l'envoi.</div>";
                    ?>
                    <div id="info-actualisation" class="alert alert-info" role="alert">Rechargé à </div>
                </div>
                <div id="left-panel">
                    <div>
                        <a id="btn-envoyes" style="display:inline-block;cursor:pointer;" onclick="messagesEnvoyes(<?php echo $_SESSION['iduser'];?>),changeButton(1)">Messages envoyés</a>
                        <a id="btn-recu" style="display:none;cursor:pointer;" onclick="closeMsg(<?php echo $_SESSION['iduser'];?>), changeButton(2)">Messages Reçus</a>
                        <a id="btn-actualiser" onclick="closeMsg(<?php echo $_SESSION['iduser'];?>),changeButton(2)" style="float:right;margin-bottom:20px;cursor:pointer; display:inline-block;"><span class="glyphicon glyphicon-refresh" style="cursor:pointer;"></span> Rafraichir</a>
                    </div>
                    <table class="table" id="table-messages">
                        <!-- Le script AJAX placera les éléments ici -->
                    </table>
                </div>
                <div id="right-panel">
                    <div id="message-content">
                        <!-- Rempli dynamiquement via AJAX -->
                    </div>
                    <div id="messages-stats">
                        <!-- Rempli dynamiquement via AJAX -->
                    </div>
                    <center><button class="btn btn-warning" onclick="printFormNewMessage()">Ecrire un message</button></center>
                </div>
            </div>
            <footer>

            </footer>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/ajaxfunctions.js"></script>
        <?php echo "<script>var idU = ".$_SESSION['iduser'].";</script>"; ?>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/squelette.js"></script>
        <script src="../js/messages.js"></script>
        <script>
            function changeButton(type){
                switch(type){
                    case 1:
                        document.getElementById("btn-envoyes").style.display = "none";
                        document.getElementById("btn-recu").style.display = "inline-block";
                        break;
                    case 2:
                        document.getElementById("btn-recu").style.display = "none";
                        document.getElementById("btn-envoyes").style.display = "inline-block";
                        break;
                    default:
                        //none
                }
            }

            function closeNewMsg(){
                document.getElementById('smoke-background-send').style.display = 'none';
            }

            function printFormNewMessage(){
                document.getElementById('smoke-background-send').style.display = 'block';
            }

            function closeMsg(idU){
                document.getElementById('smoke-background').style.display = 'none';
                refreshMessages(idU);
                refreshCounter(idU);
            }

            function closeSmoke() {
                document.getElementById('smoke-background').style.display = 'none';
            }

            function checkMailData(){
                var textarea = document.getElementById("textarea-message");
                if(textarea.value == ""){
                    alert("Veuillez remplir le contenu du mail !");
                    return false;
                } else {
                    return true;
                }
            }

            // document.getElementById("btn-envoyer").style.display = "none";
            document.getElementById('smoke-background-send').style.display = 'none';
        </script>
        <?php
            echo "<script>refreshMessages(".$_SESSION['iduser'].")</script>";
            echo "<script>refreshCounter(".$_SESSION['iduser'].")</script>";
        ?>
  </body>
</html>
