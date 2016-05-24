<?php

	session_start();


  if (!isset($_SESSION["iduser"]) ) {

  	    setcookie(nonconnecte,1,time()+4,'/');
  	    header('location: ../connexion.php');

  }

 echo "holaa";
 echo $_POST['nature'];
  //connexion bdd
  $bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
  		//recuperation de la date
        $date= date('Y-m-d H:i:s');

		if($_POST['nature']=='credit'){
				echo "im heeeeere <br>";

		        $result = pg_prepare($bdd, "my_query", 'SELECT idfin FROM financeur WHERE nomfinanceur = $1');

		        //execution des requettes

		        $result = pg_execute($bdd, "my_query",array ($_POST['source']));
		        $row=pg_fetch_row($result);

				$nbre=pg_num_rows($result);
				echo "<br>la requette a renvoyé".$nbre;
			    if ($nbre == 0){
		       		setcookie("erreur_nom_source",1,time()+4, '/');

		       		header('location: ../budget.php');

		        }


		        	$result = pg_prepare($bdd, "query", 'INSERT INTO public.flux(
		             debit, credit, libelle, datef, idfin,ideq)
			    			VALUES ( $1, $2, $3, $4, $5,$6)');

		        	$result1 = pg_execute($bdd, "query",array (0,
		        		$_POST['montant'],$_POST['libelle'],$date,$row[0],0));


        }
        else{//on est dans le cas ou on insere un debit


	        		$result = pg_prepare($bdd, "my_query", 'SELECT ideq FROM equipes WHERE nomeq = $1');

			             //execution
	        		$result = pg_execute($bdd, "my_query",array ($_POST['source']));
	        		$row=pg_fetch_row($result);

					$nbre=pg_num_rows($result);


				    if ($nbre == 0){
			       		setcookie("erreur_nom_source",1,time()+4, '/');

			       	header('location: ../budget.php');

			        }
							else{
			        $result = pg_prepare($bdd, "query", 'INSERT INTO public.flux(
			             debit, credit, libelle, datef, ideq,idfin)
				    			VALUES ( $1, $2, $3, $4, $5,$6)');

			        	$result1 = pg_execute($bdd, "query",array (
			        		"-".$_POST['montant'],0,$_POST['libelle'],$date,$row[0],0));
					}
        }
        pg_close($bdd);
       header('location: ../budget.php');


?>
