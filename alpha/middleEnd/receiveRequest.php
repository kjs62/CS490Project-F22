<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

print_r($server_output);

?>