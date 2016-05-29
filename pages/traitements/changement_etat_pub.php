<?php


// connection à la base de données:
	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");

$idpub =$_GET['idpub'];

$etat =$_GET['idetat'];

echo $idpub;
echo $etat;

if ($etat == 1){

    $result=pg_prepare($bdd,"query",'UPDATE publications set etat=$1 where idpub=$2');
    $result=pg_execute($bdd,"query",array(0,$idpub));
}
else{

    $result=pg_prepare($bdd,"requete",'UPDATE publications set etat=$1 where idpub=$2');
    $result=pg_execute($bdd,"requete",array(1,$idpub));
}

echo "le result vaut $result";
if ($result)
{
    setcookie("good1",1,time()+4, '/');
    header('location: ../publications.php');
}
else
{
    setcookie("echec2",1,time()+4, '/');
    header('location: ../publications.php');
}


?>
