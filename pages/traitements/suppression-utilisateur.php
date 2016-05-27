<?php
	session_start();

	//connexion à la bdd
	$bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requete
	$result = pg_prepare($bdd,"query",'DELETE FROM public.utilisateurs WHERE iduser = $1');
	// recupération du resultat de la requete
	$result = pg_execute($bdd, "query",array ($_GET["idU"]));

	if ($result != FALSE) {
		setcookie('success-del', 1, time()+3, '/');
		header('location: ../annuaire.php');
	}
	else {
		setcookie('erreur-even', 1, time()+3, '/');
		header('location: ../suppression-annuaire.php');
	}

	pg_close($bdd);

?>
