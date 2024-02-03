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

$id = $_GET['id'];
$user = getUser($id);

if(isset($_POST['submit'])) {
	if(ubah($_POST, $id, $_FILES['gambar']) > 0) {
		echo "<script>alert('success');
			document.location.href = 'index.php';
		</script>";
	} else {
		echo "<script>alert('failed');
		</script>";
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Edit User Page</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 </head>
<body>

<h2 class="m-5">Edit User Profile</h2>

<form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="namaGambar" value="<?= $user['gambar']; ?>">
  <div class="m-4">
    <label for="firstName" class="form-label">First Name</label>
    <input type="text" class="form-control" id="firstName" aria-describedby="emailHelp" name="firstName" value="<?= $user['firstName']; ?>">
  </div>
  <div class="m-4">
    <label for="lastName" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="lastName" aria-describedby="emailHelp" name="lastName" value="<?= $user['lastName']; ?>">
  </div>
  <div class="m-4">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="<?= $user['email']; ?>">
  </div>
  <div class="m-4">
    <img src="img/<?=$user['gambar']; ?>" width="150">
    <br>
    <label for="gambar" class="form-label">Gambar</label>
    <input type="file" class="form-control" id="gambar" name="gambar" value="<?= $user['gambar']; ?>">
  </div>
  <div class="m-4">
    <label for="bio" class="form-label">Bio</label>
    <textarea class="form-control" name="bio"><?= $user['bio']; ?></textarea>
  </div>
  <div class="m-4">
    <button type="submit" class="btn btn-warning" name="submit">Edit!</button>
	  <a href="index.php" class="btn btn-success">Back to home</a>
  </div>
</form>


</body>
</html>