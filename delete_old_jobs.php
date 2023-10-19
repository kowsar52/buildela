<?php

require_once "serverside/functions.php";

date_default_timezone_set('Europe/London');
error_reporting(1);
$func=new Functions();
echo "older posts count = ".count($func->deleteOldJobs())."<br>";
$data = $func->getAllJobs();
echo "Remaining Jobs = ".count($data);


die();

