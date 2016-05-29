<?php
  session_start();
<<<<<<< HEAD
  include "../scripts/calandar.php";

$test=$_GET['id'];
// connection à la base de données:
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=maximinus") or die("impossible de se connecter a la bdd");


// RECHERCHE Publication :
        // formulation et execution de la requette   !! fausse car il faut l'iduser !!
	    $result= pg_prepare($bdd,"query","SELECT titre,datepub,contenu,etat from Publications WHERE idpub ='$test' ");

// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ());
        
=======
  //On vérifie que l'utilisateur est passé apr le formulaire de connexion
  if (!isset($_SESSION["iduser"]) ) {
  	header('location: pages/connexion.php');
  }
  //Intérrogation de la base de données
  //connexion à la bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
	// formulation et execution de la requette
	$result= pg_prepare($bdd,"query",'SELECT idpub, titre, datepub, contenu, etat, ideq FROM publications WHERE etat = 1 AND idpub = $1');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ($_GET['id']));
>>>>>>> origin/master
  //Comptage du nombre de résultats
	$nbresults=pg_num_rows($result)	;
        
  //Récupération des résultats
  for ($i=0; $i < $nbresults; $i++) {
    $tabres = pg_fetch_array($result, $i);
    $publi['titre'][$i] = $tabres[0];
    $publi['datepub'][$i] = $tabres[1];
    $publi['contenu'][$i] = $tabres[2];
    $publi['etat'][$i] = $tabres[3];
  }

// RECHERCHE nombre Publication :
$result2= pg_query($bdd,"SELECT *FROM publications WHERE etat = 1 ");
$nbre=pg_num_rows($result2);

// Dernière publication postée:
$result3= pg_query($bdd,'SELECT titre FROM publications WHERE etat = 1 ORDER BY datepub DESC FETCH FIRST 1 ROWS ONLY');
$row=pg_fetch_row($result3);

// Date du prochain évènements:
$result4=pg_query($bdd,'SELECT dateeven FROM Evenements ORDER BY dateeven DESC FETCH FIRST 1 ROWS ONLY');
$row2=pg_fetch_row($result4);

  /* === A décommenter dès que possible ===
  if (!isset($_SESSION["idusers"]) ) {
  	setcookie(nonconnecte,1,time()+4);
  	    header('location: pages/connexion.php');
  */
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
    <link href="../css/Publications.css" rel="stylesheet">
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a>
        <fieldset id="fieldset-header" >
          <legend>Bonjour <?php echo ucfirst($_SESSION['prenom']); ?></legend>
          <a href="../pages/profil.php" class="btn-fieldset btn btn-primary">Dashboard</a>
          <a href="../pages/traitements/deconnexion.php" class="btn-fieldset btn btn-danger">Déconnexion</a>
        </fieldset>
      </header>
      <nav>
        <ul id="wrap-li">
          <li ><a href="../index.php">Accueil</a></li>
          <li ><a href="presentation.php">Présentation</a></li>
          <li class="actif"><a href="Publications.php"> Publications </a></li>
          <li><a href="evenements.php"> Evénements </a></li>
          <li><a href="messages.php"> Messages </a></li>
          <li><a href="annuaire.php"> Annuaire </a></li>
            <?php
          if ($_SESSION["statut"] = 1)
            echo "<li><a href=\"pages/budget.php\"> Budget </a></li>\n"
          ?>
          </ul>  
      </nav>
        

        
      <div class="wrap-content">
        <div id="left-panel">
            
        <?php
          for ($i=0; $i < $nbresults; $i++) {
            echo "<div id=\"un\" class=\"left-sub-panel\">";
            echo "\n\t\t<a href=\"#\" class=\"inside-panel-link\"><h2 class=\"inside-panel\">".$publi['titre'][$i]."</h2></a>";
            echo "\n\t\t<p class=\"inside-panel horodatage\"><i>publié le : ".$publi['datepub'][$i]."</i></p>";
            echo "\n\t\t<p class=\"panel-text\">".$publi['contenu'][$i]."</p>";
            echo "\n\t</div>";
          }
          ?>
          </div>
            
            
            
        <div id="right-panel">
            <div id="fieldset-right" >
                <a style="float:right;" href="Articles.php" class="btn-fieldset btn btn-primary">Rediger un article</a>
            </div>
          <div id="newmessages" >
         
            <h3 class="right-side-h3">Les statistiques</h3>
             <div id="stats">
              <?php 
                  echo "\n\t\t<p> Dernière connextion le :".date('d/m/Y à H:i', time())."</p>"; 
                  echo "\n\t\t<p> Nombre de publications : ".$nbre."</p>"; 
                  echo "\n\t\t<p> Dernière publication : ".$row[0]."</p>"; 
                  echo "\n\t\t<p> Prochain evennements le : ".$row2[0]."</p>"; 
              ?>
              </div>
          </div>
            

            
            
          <div id="calendrier">
            <h3 class="right-side-h3">Calendrier</h3>
            <p><center><strong>Mai 2016</strong></center></p>
            <?php calculateDays('mai'); ?>
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
