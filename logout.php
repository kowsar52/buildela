<?php
session_start();

require_once "serverside/functions.php";
$func=new  Functions();
$func->setOnlineStatus($_SESSION['user_id'], 'offline');
$func->removeFcmToken($_SESSION['user_id'], $_SESSION['web_fcm']);

session_destroy();
header("Location:index");
?>