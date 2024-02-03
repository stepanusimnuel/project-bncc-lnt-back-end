<?php 
session_start();
require_once "functions.php";

if(isset($_COOKIE['key']) && isset($_COOKIE['id'])) {
  $id = $_COOKIE['id'];
  $username = $_COOKIE['key'];

  $user = getUser($id);

  if($user) $_SESSION['login'] = true;
}

if(isset($_SESSION['login'])) {
	header("Location: index.php");
	exit;
}

if(isset($_POST['submit'])) {
	login($_POST);

	$err = true;
}

 ?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login Page</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 </head>
<body>

<h2 class="ms-5 mt-3">Sign In</h2>

<?php if(isset($err)): ?>
<p class="ms-4" style="color:red; font-style: italic;">username / password salah</p>
<?php endif; ?>

<form action="" method="post">
  <div class="m-4">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
  </div>
  <div class="m-4">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <div class="m-4 form-check">
    <input type="checkbox" class="form-check-input" id="remember" name="remember">
    <label class="form-check-label" for="remember">Remember me?</label>
  </div>
  <div class="m-4">
    <button type="submit" class="btn btn-primary" name="submit">Login!</button>
  </div>
</form>

</body>
</html>