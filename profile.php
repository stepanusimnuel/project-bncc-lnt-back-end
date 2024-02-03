<?php 

session_start();
require_once "functions.php";

if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

$user = getUser("U001");

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Detail User</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Attendence System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
	<div class="bg-light p-5 rounded-lg m-3">
	  <h1 class="display-4">Profile of <?= $user['lastName']; ?>, <?= $user['firstName']; ?></h1>
	  <hr class="my-4">
	  <p class="lead"><?= $user['email']; ?></p>
	  <?php if(!empty($user['bio'])): ?>
	  <p><?= $user['bio']; ?></p>
	  <?php endif; ?>
	  <a class="btn btn-warning btn-lg" href="ubah.php?id=U001" role="button">Edit Profile</a>
	  <a class="btn btn-danger btn-lg" href="logout.php" role="button">Logout</a>
	</div>
</div>

</body>
</html>