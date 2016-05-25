<?php
	session_start();

	//connexion à la bdd
	$bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	// formulation et execution de la requette
	$result = pg_prepare($bdd,"query",'INSERT INTO public.utilisateurs(nom, prenom, mail, mdp, description, statut, photo, ideq) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)');
	// recupération du resultat de la requette
	$result = pg_execute($bdd, "query",array ($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['pswd'], $_POST['description'], $_POST['statut'], $_POST['photo'], $_POST['equipe'],));

	if ($result != FALSE) {
		setcookie('success-even', 1, time()+3, '/');
		header('location: ../annuaire.php');
	}
	else {
		setcookie('erreur-even', 1, time()+3, '/');
		header('location: ../formulaire-annuaire.php');
	}

	pg_close($bdd);

?>
