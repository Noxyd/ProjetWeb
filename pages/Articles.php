<?php
    session_start();
    include "../scripts/calandar.php";

    // connection à la base de données:
    $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

    // RECHERCHE nombre Publication :
    $result2= pg_query($bdd,"SELECT *FROM publications WHERE etat = 1 ");
    $nbre=pg_num_rows($result2);

    // Dernière publication postée:
    $result3= pg_query($bdd,'SELECT titre FROM publications WHERE etat = 1 ORDER BY datepub DESC FETCH FIRST 1 ROWS ONLY');
    $row=pg_fetch_row($result3);

    // Date du prochain évènements:
    $result4=pg_query($bdd,'SELECT dateeven FROM Evenements ORDER BY dateeven DESC FETCH FIRST 1 ROWS ONLY');
    $row2=pg_fetch_row($result4);

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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


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
                    <li class="actif"><a href="publications.php"> Publications </a></li>
                    <li><a href="evenements.php"> Evénements </a></li>
                    <li ><a href="messages.php"> Messages </a></li>
                    <li><a href="annuaire.php"> Annuaire </a></li>
                    <?php
                    if ($_SESSION["statut"] = 1)
                        echo "<li><a href=\"budget.php\"> Budget </a></li>\n"
                    ?>
                </ul>
            </nav>
            <div class="wrap-content">
            <div id="left-panel">
                <?php
                if (isset($_COOKIE["good"]))
                    echo " <div class=\"alert alert-success\" role=\"alert\"> Votre publication est insérée avec succès</div>";
                if (isset($_COOKIE["echec"]))
                    echo " <div class= \"alert alert-danger\" role=\"alert\">Echec, veuillez tenter à nouveau</div>";
                ?>
                <form name="insert" action="/pages/traitements/Ajout.php" method="POST">
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" class="form-control" id="titre" title="Entrez le Titre de votre article">
                    </div>
                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <textarea class="form-control" rows="12" name="contenu" title="Entrez le contenu de l'article"></textarea>
                    </div>
                    <input type="radio" name="val" value="1"/>Poster
                    <input type="radio" name="val" value="2"/>Archiver
                    <button type="submit" value="OK" href="../pages/Publications.php" class="btn-fieldset btn btn-primary">Valider</button>
                </form>
            </div>
            <div id="right-panel">
                <div id="newmessages" >
                    <h3 class="right-side-h3">Les statistiques</h3>
                    <div id="stats">
                    <?php
                    echo "\n\t\t<p> <b>Nombre de publications : </b>".$nbre."</p>";
                    echo "\n\t\t<p> <b>Dernière publication : </b><br>".$row[0]."</p>";
                    ?>
                    </div>
                </div>
                <div id="fieldset-right" >
                    <a href="publications.php" class="btn-fieldset btn btn-primary">Retour à mes publications</a>
                </div>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/squelette.js"></script>
    </body>
</html>
