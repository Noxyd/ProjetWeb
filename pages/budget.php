<?php
  session_start();
  //controle de session et d'accessibilité pour la page budget car elle est accessible que pour le coordinateur du projet
  if (!isset($_SESSION["iduser"]) || $_SESSION["statut"]!=1 ) {

  	    setcookie(nonconnecte,1,time()+4,'/');//pose du cookie
  	    header('location: connexion.php');//redirection

  }
  //connexion a la base de donée
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
    <link href="../css/budget.css" rel="stylesheet">
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
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
          <li class="actif"><a href="budget.php"> Budget </a></li>
        </ul>
      </nav>
      <div class="wrap-content">
      <div class ="montant">
      <?php
        /*calcul du solde actuel*/
        $solde=0;
        //preparation de la requette
        $result = pg_prepare($bdd, "my_query", 'SELECT credit,debit FROM flux');
        //execution de la requette
        $result = pg_execute($bdd, "my_query",array ());
        //recuperation du nobre de lignes du resultats
        $nb_res=pg_num_rows($result);

        for ( $i=1 ; $i <= $nb_res ; $i++ ){
          $row=pg_fetch_row($result);
            $solde+=$row[0]+$row[1];
        }

        if ($solde <= 0) {
          echo "<div class=\"alert alert-danger\" role=\"alert\">Votre solde actuel est de ".$solde."€ </div>";
        }
        else {
          echo "<div class=\"alert alert-success\" role=\"alert\">Votre solde actuel est de ".$solde."€ </div>";
        }
      ?>
      </div>

          <form role="form" method="post" action="traitements/insertion_budget.php">

            <br>
              <p><nobr>Débit : <input type="radio" name="nature" value="debit" required>
                    Crédit  : <input type="radio" name="nature" value="credit" required></nobr></p>
            <br>
            <?php
              //le cookie est posé si jamais le nom du financeur ou de l'equipe est incorrecte il nous sert a afficher un message d'erreur
              if(isset($_COOKIE["erreur_nom_source"]))
                echo '<div class="alert alert-danger" role="alert"><strong>Attention ! </strong> Les données saisies sont incorrectes. Veuillez vérifier votre saisie.</div>';
            ?>
            <p>Nom du générateur du flux : <input type ="text" class="form-control" name ="source" required></p>

            <p>Montant : <input type ="text" class="form-control" name="montant" required></p>

            <p>Libellé : <input type ="text" class="form-control" name="libelle" required></p>

            <p><input type ="submit" class="btn btn-default" value ="Valider"></p>


           </form>

      </div>
      <br>
      <h2>vos dernieres operations </h2>
      <div id="evenements">
        <table class="table">
          <thead>
            <tr>
              <th>Date </th>
              <th>Libellé</th>
              <th>Montant</th>
              <th>Source</th>
            </tr>
          </thead>
          <?php
            //recuperation des dernieres operations
             $result = pg_prepare($bdd, "query", 'SELECT  distinct  datef, libelle, credit, debit ,nomfinanceur, nomeq,idflux FROM flux AS FL,equipes AS E,financeur AS FIN WHERE FL.idfin=FIN.idfin and FL.ideq = E.ideq order by idflux ');

             $result = pg_execute($bdd, "query",array ());
             $nbre_ligne=pg_num_rows($result);
             //affichage du resultat(operations)
             for($i=0; $i<$nbre_ligne ; $i++){
                $row=pg_fetch_row($result);//recupeeration de la prochaine ligne 
                /*affichage*/
                echo"\t<tr>\n";
                echo "\t\t<td>$row[0] </td>\n";
                echo "\t\t<td>$row[1] </td>\n";
                if($row[2]==0){
                  echo "\t\t<td>$row[3] </td>\n";
                  echo "\t\t<td>$row[5] </td>\n";

                }
                else{
                  echo "\t\t<td>$row[2] </td>\n";
                  echo "\t\t<td>$row[4] </td>\n";

                }
                echo "\t</tr>\n";
              }

             pg_close($bdd);// fermeture de la bdd
          ?>
        </table>

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
