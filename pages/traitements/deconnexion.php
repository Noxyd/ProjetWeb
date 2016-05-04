<?php
	session_start();
	session_unset();
	session_destroy();
	setcookie("logout",1,time()+2,'/');
		header("location: ../connexion.php");

?>