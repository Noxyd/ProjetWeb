	<?php

	session_start();//lancement de la session


	if (!isset($_SESSION["iduser"]) ) {//verification de sesion

		setcookie(nonconnecte,1,time()+4,'/');
		header('location: ../connexion.php');

	}



	//connexion bdd
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
	//recuperation de la date
	$date= date('Y-m-d H:i:s');

	if($_POST['nature']=='credit'){//le cas ou on insere un credit
	
		// verification de l'existance du financeur dans la base pour eviter les erreurs
		$result = pg_prepare($bdd, "my_query", 'SELECT idfin FROM financeur WHERE nomfinanceur = $1');

		//execution des requettes

		$result = pg_execute($bdd, "my_query",array ($_POST['source']));
		$row=pg_fetch_row($result);

		$nbre=pg_num_rows($result);
		echo "<br>la requette a renvoyé".$nbre;
		if ($nbre == 0){// on a pas recu de resultats càd qu'on s'est trompé dans le nom alos:
			setcookie("erreur_nom_source",1,time()+4, '/');//on pose un cookie

			header('location: ../budget.php');//on le renvoie a la page budget.php

		}

		//etant ici ca veut dire qu'on a rentré le bon nom de l'organisme
		//insertion de l'operation dans la table flux 
		$result = pg_prepare($bdd, "query", 'INSERT INTO public.flux(
			debit, credit, libelle, datef, idfin,ideq)
			VALUES ( $1, $2, $3, $4, $5,$6)');

		$result1 = pg_execute($bdd, "query",array (0,
			$_POST['montant'],$_POST['libelle'],$date,$row[0],0));


	}
	else{//on est dans le cas ou on insere un debit

		//on verifie l'existance du debiteur
		$result = pg_prepare($bdd, "my_query", 'SELECT ideq FROM equipes WHERE nomeq = $1');

		//execution
		$result = pg_execute($bdd, "my_query",array ($_POST['source']));
		$row=pg_fetch_row($result);

		$nbre=pg_num_rows($result);
		
		//on verifie si le nom est bon sinon on le renvoie à la page budget tout en posant un cookie
		if ($nbre == 0){
			setcookie("erreur_nom_source",1,time()+4, '/');

			header('location: ../budget.php');

		}
		else{//on insere le flux
			$result = pg_prepare($bdd, "query", 'INSERT INTO public.flux(
				debit, credit, libelle, datef, ideq,idfin)
				VALUES ( $1, $2, $3, $4, $5,$6)');

			$result1 = pg_execute($bdd, "query",array (
				"-".$_POST['montant'],0,$_POST['libelle'],$date,$row[0],0));
		}
	}
	pg_close($bdd);//fermeture de la conexion
	header('location: ../budget.php');//on redirige vers la table flux


	?>
