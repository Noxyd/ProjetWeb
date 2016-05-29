<?php
	session_start();

	//connexion à la bdd
	$bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requete
	$result = pg_prepare($bdd,"query",'DELETE FROM public.taches WHERE id_taches = $1');
	// recupération du resultat de la requete
	$result = pg_execute($bdd, "query",array ($_GET["idT"]));

	if ($result != FALSE) {
		setcookie('success-del', 1, time()+3, '/');
		header('location: ../suppression-tache.php');
	}
	else {
		setcookie('erreur-del', 1, time()+3, '/');
		header('location: ../suppression-tache.php');
	}

	pg_close($bdd);

?>
