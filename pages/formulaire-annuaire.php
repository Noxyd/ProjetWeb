<?php
  session_start();

  $string = "Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.";


  if (!isset($_SESSION["iduser"]) || $_SESSION["statut"]!=1) {

  	    setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: connexion.php');

  }
  $bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

  $result = pg_prepare($bdd,"query",'select nomeq from equipes');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query", array());
  $nbresults = pg_num_rows($result);
  // On fait une boucle pour récuperer le nom des équipes
  for($i=1 ; $i < $nbresults ; $i++){
    $row=pg_fetch_row($result);
    // Stockage des variables extraits de la base dans une variable
    $user[$i] = $row[0];
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
    <link href="../css/formulaire-annuaire.css" rel="stylesheet">
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
          <li><a href="presentation.php"> Publications </a></li>
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li class="actif"><a href="annuaire.php"> Annuaire </a></li>
          <?php
          if ($_SESSION["statut"] == 1)
            echo "<li><a href=\"budget.php\"> Budget </a></li>\n"
          ?>
        </ul>
      </nav>

      <div class="wrap-content">
        <?php
          if (isset($_COOKIE['erreur-reqst'])) {
            echo '<div class="alert alert-danger" role="alert"><strong>Attention ! </strong> L\'utilisateur n\'a pas pu être ajouté.</div>';
          }
          if (isset($_COOKIE['erreurs-img'])) {
            echo '<div class="alert alert-danger" role="alert"><strong>Attention ! </strong> La photo n\'a pas pu être ajoutée.</div>';
          }
          if (isset($_COOKIE['flag_error_mail'])) {
            echo '<div class="alert alert-danger" role="alert"><strong>Attention ! </strong>Le mail saisi existe déjà.</div>';
          }
        ?>

        <h2>Ajouter un utilisateur</h2>

        <div class="Formulaire">
          <form action="traitements/insertion_utilisateur.php" method="post" enctype="multipart/form-data">
            <label>Nom :</label>
            <p> <input type="text" class="form-control" name="nom" required></p>
            <label>Prénom :</label>
            <p><input type="text" class="form-control" name="prenom" required></p>
            <p><strong>Coordinateur</strong><input style="margi" type="checkbox" name="statut" value="1"></p>
            <label>Equipe :</label>
              <?php
              echo "<p><select name=\"equipe\" class=\"form-control\" required>";
                // On fait une boucle pour afficher toutes les équipes depuis la table nomeq
                for($i=1 ; $i < $nbresults ; $i++){
                  echo "<option value=\"".$i."\">".$user[$i]."</option>";
                }
                echo "</select></p>";
              ?>
            <label>Adresse mail :</label>
            <p><input type="email" class="form-control" name="mail" placeholder="prenom.nom@sciencehub.com" required></p>
            <label>Mot de passe :</label>
            <p><input type="password" class="form-control" name="pswd" required></p>
            <label>Description :</label>
            <p><textarea class="form-control" rows="5" name="description" required></textarea></p>
            <label>Photo (format .jpg) :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="500000">
            <input type="file" style="margin-bottom:20px;" name='photo' required>
            <button type="submit" class="btn btn-default">Enregistrer</button>
            <div class="bouton">
              <a href="annuaire.php" class="btn btn-danger">Annuler</a>
            </div>
          </form>
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
    <script src="js/bootstrap.min.js"></script>
    <script src="js/squelette.js"></script>
  </body>
</html>
