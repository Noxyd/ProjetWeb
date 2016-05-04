<?php
session_start();
  if (isset($_SESSION["idusers"]) ) {
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
  </head>
  <body>
    <div id="wrap-container">
      <header>
        <center><a href="#"><img id="logo" src="../images/logo/logo-transparent-nom.png"/></a></center>
      </header>
      <div id="wrap-content">
        <form id="form-cnx" method="post" action="traitements/verifauth.php">
          <h1>Connectez-vous</h1>
           
          <table>
          <tr>
            <td></td>
            <td>
                <?php
            	if (isset($_COOKIE["auth_error"])){
             	 echo " <u style=\"color:red;\">echec d'authentification</u>";
              	}
              	if (isset($_COOKIE["logout"])){
              	echo " <u style=\"color:green;\">Vous êtes bien déconnecté !</u>";
              	}
              	if (isset($_COOKIE["nonconnecte"])){
              	echo " <u style=\"color:red;\">Veuillez vous authentifier !</u>";
              	}

          		?>
            </td>
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
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
