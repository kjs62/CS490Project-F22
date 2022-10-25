<?php
session_start();
// remove all session variables
session_unset();
// destroy the session
session_destroy();
?>
<?php
die(header("Location: beta_front.php"));
?>