<?php
	session_start();

	//connexion à la bdd
	$bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
	// formulation et execution de la requete
	$result = pg_prepare($bdd,"query",'INSERT INTO public.taches(tache, deadline, etat, ideq) VALUES ($1, $2, $3, $4)');
	// recupération du resultat de la requete
	$result = pg_execute($bdd, "query",array ($_POST['descriptif'], $_POST['date'], 0, $_POST['equipe']));

	if ($result != FALSE) {
		setcookie('success-add', 1, time()+3, '/');
		header('location: ../profil.php');
	}
	else {
		setcookie('erreur-tache', 1, time()+3, '/');
		header('location: ../formulaire-tache.php');
	}

	pg_close($bdd);

?>
