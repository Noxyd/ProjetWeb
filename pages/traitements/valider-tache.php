<?php
	session_start();

	//connexion à la bdd
	$bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requete
	$result = pg_prepare($bdd,"query",'UPDATE public.taches SET etat=$1 WHERE id_taches = $2');
	// recupération du resultat de la requete
	$result = pg_execute($bdd, "query",array (1,$_GET["idT"]));

	if ($result != FALSE) {
		header('location: ../profil.php');
	}
	else {
		setcookie('erreur-val', 1, time()+3, '/');
		header('location: ../profil.php');
	}

	pg_close($bdd);

?>
