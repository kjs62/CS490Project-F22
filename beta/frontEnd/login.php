'''
<?php
  $ucid="UCID MATCH";
  $password="Password MATCH";
  $username=$_POST['ucid'];
  $Password=$_POST['password'];
  $post = array(
        'ucid' => $ucid,
        'password' => $password,
        'username' => $username,
        'Password' => $Password,
    );
  echo json_encode($post);
?>
'''