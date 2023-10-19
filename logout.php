<?php
session_start();

require_once "serverside/functions.php";
$func=new  Functions();
$func->setOnlineStatus($_SESSION['user_id'], 'offline');

session_destroy();
header("Location:index");
?>