<?php 

	chdir(dirname(__FILE__));
	include "functions.php";
	$Functions = new Functions();
	$Functions->sendNewUserEmail();

 ?>