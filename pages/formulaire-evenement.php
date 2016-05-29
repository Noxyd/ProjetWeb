<?php
    session_start();

    if (!isset($_SESSION["iduser"]) ) {
        setcookie('nonconnecte',1,time()+4,'/');
        header('location: connexion.php');
    }
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
        <link href="../css/formulaire-evenement.css" rel="stylesheet">
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
                    <li class="actif"><a href="evenements.php"> Evénements </a></li>
                    <li><a href="messages.php"> Messages </a></li>
                    <li><a href="annuaire.php"> Annuaire </a></li>
                    <?php
                    if ($_SESSION["statut"] == 1)
                        echo "<li><a href=\"budget.php\"> Budget </a></li>\n"
                    ?>
                </ul>
            </nav>
            <div class="wrap-content">
                <?php
                if (isset($_COOKIE['erreur-even'])) {
                echo '<div class="alert alert-danger" role="alert"><strong>Attention ! </strong> L\'événement n\'a pas pu être enregistré.</div>';
                }
                ?>
                <h2>Création d'un événement</h2>
                <div class="Formulaire">
                    <form action="traitements/insertion_events.php" method="post">
                        <label>Titre :</label>
                        <p> <input type="text" class="form-control" name="titre" required></p>
                        <label>Date :</label>
                        <p><input type="date" class="form-control" name="date" placeholder="ex: 2016-05-30"required></p>
                        <label>Lieu :</label>
                        <p><input type="text" class="form-control" name="lieu" required></p>
                        <label>Description :</label>
                        <p><textarea class="form-control" rows="5" name="description" required></textarea></p>
                        <button type="submit" class="btn btn-default">Enregistrer</button>
                        <div class="bouton">
                            <a href="evenements.php" class="btn-fieldset btn btn-danger">Annuler</a>
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
