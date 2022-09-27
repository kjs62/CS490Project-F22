<?php

$ucid = $_POST['ucid'];
$pass = $_POST['password'];
$requestType = $_POST['type'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "ucid=$ucid&password=$pass&type=$requestType");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

echo $server_output;

?>