<?php
    session_start();
    //controle de session et d'accessibilité pour la page budget car elle est accessible que pour le coordinateur du projet
    if (!isset($_SESSION["iduser"]) || $_SESSION["statut"]!=1 ) {
        setcookie('nonconnecte',1,time()+4,'/');//pose du cookie
        header('location: connexion.php');//redirection
    }
    //connexion a la base de donée
    $bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

    $prepare = pg_prepare($bdd,"query",'SELECT datef,debit,credit,libelle,nomfinanceur,nomeq FROM (flux fl INNER JOIN financeur fi ON fl.idfin=fi.idfin) LEFT JOIN equipes eq ON fl.ideq=eq.ideq ORDER BY datef DESC;');

    $execute = pg_execute($bdd, "query",array());

    $countResults=pg_num_rows($execute);

    $cpt_debit = 0;
    $cpt_credit = 0;

    for ($i=0; $i < $countResults; $i++) {
        $tabres = pg_fetch_array($execute, $i);
        $flux['datef'][$i] = $tabres[0];
        $flux['debit'][$i] = $tabres[1];
        $flux['credit'][$i] = $tabres[2];
        $flux['libelle'][$i] = $tabres[3];
        $flux['nomfinanceur'][$i] = $tabres[4];
        $flux['nomeq'][$i] = $tabres[5];

        if ($flux['credit'][$i] == 0) {
            $cpt_debit += $flux['debit'][$i];
        }

        if ($flux['debit'][$i] == 0) {
            $cpt_credit +=  $flux['credit'][$i];
        }
    }

    $total = $cpt_credit - $cpt_debit;
    pg_close($bdd);// fermeture de la bdd
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
                if ($total <= 0) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">Votre solde actuel est de ".$total."€ </div>";
                }
                else {
                echo "<div class=\"alert alert-success\" role=\"alert\">Votre solde actuel est de ".$total."€ </div>";
                }
                ?>
                </div>
                <form style="margin-top:50px;"role="form" method="post" action="traitements/insertion_budget.php">
                    <p>
                        <nobr>
                        Débit : <input type="radio" name="nature" value="debit" checked="checked" required>
                        Crédit  : <input type="radio" name="nature" value="credit" required>
                        </nobr>
                        <br><br>
                    </p>
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
            <h2>Vos dernières opérations </h2>
            <div id="evenements">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date </th>
                            <th>Libellé</th>
                            <th>Débit</th>
                            <th>Crédit</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <?php
                    //recuperation des dernieres operations
                    //affichage du resultat(operations)
                    for($i=0; $i<$countResults; $i++){
                        echo "<tr>";
                        echo "<td>".date('d/m/Y',strtotime($flux['datef'][$i]))."</td>";
                        echo "<td>".$flux['libelle'][$i]."</td>";
                    if($flux['debit'][$i] != 0)
                        echo "<td>".$flux['debit'][$i]."</td>";
                    else
                        echo "<td>-</td>";
                    if($flux['credit'][$i] != 0)
                        echo "<td>".$flux['credit'][$i]."</td>";
                    else
                        echo "<td>-</td>";
                    echo "<td>".$flux['nomfinanceur'][$i].$flux['nomeq'][$i]."</td>";
                    echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <footer>
                <h4> © BLANCHET / GARCIA / MEHDIOUI / SARMA</h4>
                <p>Tous droits réservés.</p>
            </footer>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/squelette.js"></script>
    </body>
</html>
