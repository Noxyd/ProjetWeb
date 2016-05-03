

<?php
	session_start();

	//recuperation des champs du formulaire
	$password=$_POST["password"];
	$identifiant=$_POST["mail"];
	//connexion à la bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requette
	$result= pg_query($bdd,"select statut,idusers,nom,mdp,mail,prenom from users where mdp = '$password' and mail ='$identifiant'");
	// recupération du resultat de la requette
	$i=pg_num_rows($result)	;
		
	if ($i === 0){
		setcookie("auth_error",2,time()+4);
		header('location: connexion.php');
	}
	else{ 
		$row=pg_fetch_row($result);

		$_SESSION["statut"]=$row[0];
		$_SESSION["idusers"]=$row[1];
		$_SESSION["nom"]=$rom[2];
		$_SESSION["mail"]=$row[4];
		$_SESSION["prenom"]=$row[5];

		header('location: ../index.php');
	}




?>