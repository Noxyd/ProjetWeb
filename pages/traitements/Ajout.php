<?php

	session_start();
	// connection à la base de données:
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

	$val =$_POST['val'];

	$titre =$_POST['titre'];

	$contenu =$_POST['contenu'];

	$date = date('Y-m-d H:i');

	switch($val){
		case 1 :
			$result =pg_prepare($bdd,"query","INSERT INTO Publications(titre,contenu,etat, datepub,ideq) VALUES ($1,$2,$3,$4,$5)");
			$result=pg_execute($bdd,"query",array($titre,htmlentities($contenu),1,$date,$_SESSION["ideq"]));
			break;

		case 0 :
			$result =pg_prepare($bdd,"query","INSERT INTO Publications(titre,contenu,etat, datepub,ideq) VALUES ($1,$2,$3,$4,$5)");
			$result=pg_execute($bdd,"query",array($titre,htmlentities($contenu),0,$date,$_SESSION["ideq"]));
			break;
	}



	if ($result != false)
	{
		setcookie("good",1,time()+4, '/');
		header('location: ../Articles.php');
	}
	else
	{
		setcookie("echec",1,time()+4, '/');
		header('location: ../Articles.php');
	}

	pg_close($bdd);
?>
