<?php
session_start();
  if (isset($_SESSION["iduser"]) ) {
    header('location: ../index.php');
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
    <link href="../css/connexion.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/logo/favicon.png">
  </head>
  <body>
    <div id="wrap-container">
      <header>

      </header>
      <div id="wrap-content">
        <form id="form-cnx" method="post" action="traitements/verifauth.php">
            <center><img id="logo" src="../images/logo/logo-transparent-nom.png"/></center>

          <table>
          <tr>
              <?php
            	if (isset($_COOKIE["auth_error"]))
                echo '<div class="alert alert-danger" role="alert"><strong>Attention !</strong> Echec d\'authentification.</div>';
              if (isset($_COOKIE["logout"]))
                echo '<div class="alert alert-success" role="alert">Vous êtes bien déconnecté !</div>';
          		?>
          </tr>
            <tr>
              <td><p>Adresse mail :</p></td>
              <td><input type="email" name="mail" ></td>
            </tr>
            <tr>
              <td><p>Mot de passe :</p></td>
              <td><input type="password" name="password"></td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" class="btn btn-success" value="Connexion"></td>

            </tr>
          </table>
        </form>

      </div>
      <!-- <footer id="footer">
          <h4> © BLANCHET / GARCIA / MEHDIOUI / SARMA</h4>
          <p>Tous droits réservés.</p>
      </footer> -->
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
