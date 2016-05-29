<?php
  session_start();


  if (!isset($_SESSION["iduser"]) ) {//contole de session pour verifier si l'utilisateur est effectivement connecté
  	    setcookie(nonconnecte,1,time()+4,'/');//poser le cookie de verification
  	    header('location: connexion.php');//renvoyer vers la page de connexion

  }
  //connexion a la base de données
  $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

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
        <a href="../index.php"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
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
        <div class="bouton-evenement">
          <a href="formulaire-evenement.php" class="btn-fieldset btn btn-default">Créer événement</a>
        </div>
        <?php
          //affichage d'un message lors d'une insertio reussie
          if (isset($_COOKIE['success-even'])) {
            echo '<div class="alert alert-success" role="alert">L\'événement a été enregistré avec succès !</div>';
          }
        ?>

       <h2>À venir</h2>

       <div id="evenements">
        <table class="table">
         <thead>
            <tr>
              <th>Intitulé </th>
              <th>Date</th>
              <th>Lieu</th>
            </tr>
          </thead>
         <?php
           //preparation de la requete
           $result0= pg_prepare($bdd, "req", 'SELECT * FROM evenements');
           //execution de la requete
           $result0= pg_execute($bdd, "req", array ());
           //recuperation du nombre de ligne du resultat
           $nb_result=pg_num_rows($result0);

           // Bloc permettant de modifier la variable d'état en fonction de si l'événement est passé ou à venir
           $requete = "requete"; //  On initialise la variable avec un début de chaine de caractère
           for ($i=1; $i <= $nb_result; $i++) {
             $row=pg_fetch_row($result0);
             $date = date('Y-m-d'); //  On récupère la date du PC
             if ($date >= $row[2]) {  //  Si la date de l'événement est inférieur ou égale à la date actuelle
               $requete.=$i;  //  On incrémente la variable à cause des contraintes postgres
               pg_prepare($bdd, "$requete", 'UPDATE public.evenements SET statut=$1 WHERE ideven=$2');
               pg_execute($bdd, "$requete", array (0, $row[0]));  //  On affecte la valeur du statut à 0 (passé)
             }
           }

           //reuperation des evenements a venir en requette preparé
            $result = pg_prepare($bdd, "my_query", 'SELECT * FROM evenements WHERE statut=0 order by dateeven');
            // recuperation des eveneents passés en requette preparé
            $result1 = pg_prepare($bdd, "query", 'SELECT * FROM evenements WHERE statut=1 order by dateeven');
            //execution des requettes

            $result1 = pg_execute($bdd, "my_query",array ());

            $result = pg_execute($bdd, "query",array ());

            // recuperation nombre de lignes
            $nb_res=pg_num_rows($result);

            for ( $i=1 ; $i <= $nb_res ; $i++ ){
                    $row=pg_fetch_row($result);//mettre sous forme de tableau
                      echo"<tr>\n";
                          echo "\t\t<td><a href=\"detailsevenements.php?id=$row[0]\">". $row[1]."</a></u></td>\n";
                          echo "\t\t<td>". $row[2]." </td>\n " ;
                          echo "\t\t<td>".$row[3]."</td>\n" ;
                      echo "\t</tr>\n";
            }

         ?>
        </table>
    </div>

      <br>
      <h2>Passés</h2>
      <div id="evenements">
        <table class="table">
          <thead>
            <tr>
              <th>Intitulé</th>
              <th>Date</th>
              <th>Lieu</th>
            </tr>
          </thead>
          <?php
            $nb_res=pg_num_rows($result1);

            for ( $i=1 ; $i <= $nb_res ; $i++ ){
                $row=pg_fetch_row($result1);

                  echo"<tr>\n";
                  echo "\t\t<td><a href=\"detailsevenements.php?id=$row[0]\">". $row[1]."</a></u></td>\n ";

                  echo "\t\t<td>".$row[2]." </td>\n";
                  echo "\t\t<td>".$row[3]."</td>\n";
                  echo "\t</tr>\n";
            }
            pg_close($bdd);
          ?>
        </table>
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
