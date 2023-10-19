<?php
$ipAddress = $_SERVER["REMOTE_ADDR"];
$deviceInfo = $_SERVER["HTTP_USER_AGENT"];

$userInfo = array(
    'ip_address' => $ipAddress,
    'device_info' => $deviceInfo
);

header('Content-Type: application/json');
echo json_encode($userInfo);

?>