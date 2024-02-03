<?php 

session_start();
require_once "functions.php";

if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

$users = getAllUsers();

if(isset($_POST['search'])) {
  $users = search($_POST['keyword']);
}

 ?>


<!doctype html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Home Page</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

   <style type="text/css">
     footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
     }
     header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
     }
   </style>

 </head>

 <body>
<header>
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
      <form class="d-flex" role="search" action="" method="post">
        <input class="form-control me-2" type="search" placeholder="search keyword..." aria-label="Search" size="60" name="keyword" autocomplete="off" autofocus="on">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
      </form>
    </div>
  </div>
 </nav>
</header>

<br>
<a class="btn btn-success ms-5 mt-5" href="tambah.php">+New User</a>
<?php if(isset($_POST['search'])): ?>
<a class="btn btn-info ms-2 mt-5" href="index.php">Show All</a>
<?php endif; ?>

<table class="table table-striped mt-3 mb-5">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach($users as $user): ?>
    <tr>
      <th scope="row"><?= $i; ?></th>
      <td><?= $user['firstName'] . ' ' . $user['lastName']; ?></td>
      <td><?= $user['email']; ?></td>
      <td>
      	<a class="btn btn-primary" href="detail.php?id=<?= $user['id']; ?>">Detail</a>
      	<a class="btn btn-warning ms-3" href="ubah.php?id=<?= $user['id']; ?>">Edit</a>
      	<a class="btn btn-danger ms-3" href="hapus.php?id=<?= $user['id']; ?>" onclick="return confirm('you can\'t undo user once deleted')">Delete</a>
      </td>
    </tr>
    <?php $i++;endforeach; ?>
  </tbody>
</table>


  <footer>
    <div class="card text-center">
      <div class="card-footer text-body-secondary">
        &copyCopyright 2024
      </div>
    </div>
  </footer>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 </body>
</html>