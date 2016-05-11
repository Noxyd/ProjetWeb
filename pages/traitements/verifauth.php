

<?php
	session_start();

	//recuperation des champs du formulaire
	$password=$_POST["password"];
	$identifiant=$_POST["mail"];
	//connexion à la bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requette
	$result= pg_prepare($bdd,"query",'select statut,iduser,nom,mdp,mail,prenom,ideq from utilisateurs where mdp = $1 and mail =$2');
	// recupération du resultat de la requette
	 $result = pg_execute($bdd, "query",array ($password,$identifiant));
	$i=pg_num_rows($result)	;
		
	if ($i === 0){
		setcookie("auth_error",1,time()+4, '/');
		
		header('location: ../connexion.php');
	}
	else{ 
		$row=pg_fetch_row($result);

		$_SESSION["statut"]=$row[0];
		$_SESSION["iduser"]=$row[1];
		$_SESSION["nom"]=$row[2];
		$_SESSION["mail"]=$row[4];
		$_SESSION["prenom"]=$row[5];
		$_SESSION["ideq"]=$row[6];

	;
		header('location: ../../index.php');
	}




?>