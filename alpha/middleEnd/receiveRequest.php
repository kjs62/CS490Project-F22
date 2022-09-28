<?php

$data = array(
  'ucid' => $_POST['ucid'],
  'password' => $_POST['password'],
  'requestType' => $_POST['requestType']
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/alpha/backEnd/backEndAPI.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

echo $server_output;

?>