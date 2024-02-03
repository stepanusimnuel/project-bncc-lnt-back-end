<?php 
session_start();
require_once "functions.php";

if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

if(!isset($_GET['id'])) {
  header("Location: login.php");
  exit;
}

if(hapus($_GET['id']) > 0) {
	echo "<script>alert('success');
			document.location.href = 'index.php';
		</script>";
} else {
	echo "<script>alert('failed');
		</script>";
}

 ?>