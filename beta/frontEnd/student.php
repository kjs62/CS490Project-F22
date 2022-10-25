<?php session_start(); ?>
<?php require_once("nav.php");?>

<h1>Student Landing Page</h1>
<h3>
<?php if($_SESSION['user'] == 1): ?>
Hello kjs62
<?php else: ?>
Hello sgs6
<?php endif; ?>
</h3>
<head><link rel="stylesheet" href="beta.css"></head>