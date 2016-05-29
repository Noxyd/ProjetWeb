<?php
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";


  if (!isset($_SESSION["iduser"]) || $_SESSION["statut"]!=1) {

  	    setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: connexion.php');

  }
  $bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

  // formulation et execution de la requete
  $result2 = pg_prepare($bdd,"query2", 'SELECT id_taches, tache, deadline, etat, nomeq FROM public.taches, public.equipes WHERE taches.ideq = equipes.ideq ORDER BY deadline');
  // récupération du résultat de la requete
  $result2 = pg_execute($bdd, "query2", array());
  $nbresults = pg_num_rows($result2);
  // On fait une boucle pour afficher toutes les taches
  for($i=1 ; $i <= $nbresults ; $i++){
    $row = pg_fetch_row($result2);

    $taches["idtache"][$i] = $row[0];
    $taches["tache"][$i] = $row[1];
    $taches["deadline"][$i] = $row[2];
    $taches["etat"][$i] = $row[3];
    $taches["nomeq"][$i] = $row[4];

    if ($taches["etat"][$i] == 0) {
      $etat[$i] = "En cours";
    }
    if ($taches["etat"][$i] == 1) {
      $etat[$i] = "Terminée";
    }
  }
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
    <link href="../css/suppression-tache.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="../index.php"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour  <?php echo ucfirst($_SESSION["prenom"]); ?></legend>
          <a href="profil.php" class="btn btn-info">Dashboard</a>
          <a href="traitements/deconnexion.php" class="btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li><a href="../index.php">Accueil</a></li>
          <li><a href="presentation.php" >Présentation</a></li>
          <li><a href="presentation.php"> Publications </a></li>
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
          <li><a href=\"budget.php\"> Budget </a></li>
        </ul>
      </nav>

      <div class="wrap-content">
        <div class="notification">
          <?php
            //affichage d'un message lors d'une suppression reussie
            if (isset($_COOKIE['success-del'])) {
              echo '<div class="alert alert-success" role="alert">La tâche a été supprimée avec succès !</div>';
            }
            if (isset($_COOKIE['erreur-del'])) {
              echo '<div class="alert alert-danger" role="alert"><strong>Attention ! </strong> La tâche n\'a pas pu être supprimée.</div>';
            }
          ?>
        </div>
        <h2>Suppression d'une tâche</h2>
        <div class="Tache">
          <table class="table">

            <thead>
              <tr>
                <th>Tâches</th>
                <th>Deadline</th>
                <th>Equipe</th>
                <th>Etat</th>
                <th>Supprimer</th>
              </tr>
            </thead>
            <?php
              $nbresults=pg_num_rows($result2);

              for ( $i=1 ; $i <= $nbresults ; $i++ ){
                      $row=pg_fetch_row($result2);//mettre sous forme de tableau
                        echo"<tr>\n";
                            echo "\t\t<td>".$taches["tache"][$i]."</td>\n";
                            echo "\t\t\t<td>".$taches["deadline"][$i]."</td>\n";
                            echo "\t\t\t<td>".ucfirst($taches["nomeq"][$i])."</td>\n";
                            echo "\t\t\t<td>".$etat[$i]."</td>\n";
                            echo "\t\t\t<td><a href=\"traitements/supprimer-tache.php?idT=".$taches["idtache"][$i]."\"><span class=\"glyphicon glyphicon-remove\"></span></a></td>\n";
                        echo "\t\t</tr>\n";
              }
            ?>
          </table>
          <div class="bouton">
            <a href="profil.php" class="btn btn-default">Retour au dashboard</a>
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
    <script src="js/squelette.js"></script>
  </body>
</html>
