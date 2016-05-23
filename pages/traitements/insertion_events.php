<?php
	session_start();

	//connexion à la bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requette
	$result= pg_prepare($bdd,"query",'INSERT INTO public.evenements(intitule, dateeven, lieu, description, statut, ideq) VALUES ($1, $2, $3, $4, $5, $6)');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ($_POST['titre'], $_POST['date'], $_POST['lieu'], $_POST['description'], 1, $_SESSION['ideq']));

	if ($result != FALSE) {
		setcookie('success-even', 1, time()+3, '/');
		header('location: ../evenements.php');
	}
	else {
		setcookie('erreur-even', 1, time()+3, '/');
		header('location: ../formulaire-evenement.php');
	}

	pg_close($bdd);

?>
