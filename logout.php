<?php 
session_start();
if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

session_start();
session_destroy();
session_unset();
$_SESSION = [];

setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

header("Location: login.php");

 ?>