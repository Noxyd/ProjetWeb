<?php
	session_start();

	$maxsize = $_POST['MAX_FILE_SIZE'];

	/* ===  Test de l'existance du mail === */
	$bdd = pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
	$prepare = pg_prepare($bdd,"querymail",'SELECT mail FROM utilisateurs;');
	$execute = pg_execute($bdd, "querymail",array ());

	$nbmails = pg_num_rows($execute);
	$flag = 0;
	for($i=0;$i<$nbmails;$i++){
		$tabres = pg_fetch_array($execute, $i);
		if($tabres[0] == $_POST['mail']){
			$flag=1;
		}
	}

	if($flag == 1){
		//ERROR : le mail existe déjà
		setcookie('flag_error_mail', 1, time() + 3, '/');
		header('location: ../formulaire-annuaire.php');
	}

	//Tests sur le fichier image
    //Flag d'erreur
  if ($_FILES['photo']['error'] > 0) {
    //ERROR
    setcookie('flag_error', 1, time() + 3, '/');
    header('location: ../formulaire-annuaire.php');
  }

    //taille maximale
  if ($_FILES['photo']['size'] > $maxsize) {
    setcookie('flag_error', 1, time() + 3, '/');
    header('location: ../formulaire-annuaire.php');
  }

  $extensions_valides = array( 'jpg' , 'jpeg' , 'png' );
  $extension_upload = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );

    //extension valide
  if ( !in_array($extension_upload,$extensions_valides) ) {
    //ERROR
    setcookie('flag_error', 1, time() + 3, '/');
    header('location: ../formulaire-annuaire.php');
  }

  $new_name = $_POST['prenom'].'_'.$_POST['nom'];
	// $new_name = $_POST['prenom'];
  $target_path = "../../images/".$new_name.".".$extension_upload;
  $upload1 = @move_uploaded_file($_FILES['photo']['tmp_name'], $target_path);

	$photo = "../images/".$new_name.".".$extension_upload;

	// On défini le statut de l'utilisateur
	if (!empty($_POST["statut"])) {
		$statut = 1;
	}else {
	  $statut = 0;
	}

	if($upload1 == TRUE){

		// formulation et execution de la requete
		$result = pg_prepare($bdd,"query",'INSERT INTO utilisateurs(nom, prenom, mail, mdp, description, statut, photo, ideq) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)');
		// recupération du resultat de la requete
		$result = pg_execute($bdd, "query",array ($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['pswd'], $_POST['description'], $statut, $photo, $_POST['equipe']));

		pg_close($bdd);
		if ($result != FALSE) {
			setcookie('success-even', 1, time()+3, '/');
			header('location: ../annuaire.php');
		}
		else {
			setcookie('erreur-reqst', 1, time()+3, '/');
			header('location: ../formulaire-annuaire.php');
		}

	}else {
		setcookie('erreurs-img', 1, time()+3, '/');
		header('location: ../formulaire-annuaire.php');
	}



?>
