<?php 

$dbh = conn();
$stmt = "";

function conn() {
	$dbHost = "localhost";
	$dbName = "attendance_system";
	$dbPassword = '';
	$dbUser = 'root';

	$dsn = "mysql:host=$dbHost;dbname=$dbName";

	try {
		$dbh = new PDO($dsn, $dbUser, $dbPassword);
	} catch(PDOException $e) {
		die($e->getMessage());
	}

	return $dbh;
}



function closeDB() {
	$dbh = null;
	$stmt = null;
}

function login($data) {
	$dbh = conn();
	$stmt = $dbh->prepare("SELECT * FROM user WHERE email = ?");

	$stmt->execute([
		$data['email']
	]);

	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if(!$user) return;

	if(password_verify($data['password'], $user['password'])) {
		$_SESSION['login'] = true;
		if(isset($data['remember'])) {
			setcookie('id', $user['id'], time() + 60);
			setcookie('key', hash('gost', $user['email']), time() + 60);
		}
		header("Location: index.php");
		exit;
	}
}

function formatID($id) {
	$n = 4;
	$str = '';

	for($i = 1; $i < $n; $i++ ){
		if($id[$i] != '0') {
			$str = substr($id, $i, $n - $i + 1);
			break;
		}
	}

	$str = (int)$str;
	$str++;
	$str = strval($str);

	while(strlen($str) != $n - 1) $str = '0' . $str;
	$str = 'U' . $str;

	return $str;
}

function getUser($id) {
	$dbh = conn();
	$stmt = $dbh->prepare("SELECT * FROM user WHERE id = ?");

	$stmt->execute([
		$id
	]);

	return $stmt->fetch();
}	

function getAllUsers() {
	$dbh = conn();
	$stmt = $dbh->prepare("SELECT * FROM user WHERE id != 'U001'");

	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function create($data, $dataGambar) {
	$dbh = conn();
	
	$id = $dbh->prepare("SELECT id FROM user ORDER BY id DESC LIMIT 1");
	$id->execute();

	$id = $id->fetch(PDO::FETCH_ASSOC)['id'];

	$id = formatID($id);

	$stmt = $dbh->prepare("INSERT INTO user (id, firstName, lastName, email, password, bio, gambar) VALUES(?, ?, ?, ?, ?, ?, ?)");

	$gambar = upload($dataGambar);

	if(!$gambar) {
		return false;
	}

	$stmtEmail = $dbh->prepare("SELECT email FROM user WHERE email = ?");
	$stmtEmail->execute([$data['email']]);
	$isUniqueEmail = $stmtEmail->fetch(PDO::FETCH_ASSOC);

	if($isUniqueEmail) {
		echo "<script>alert('email used');</script>";
		return false;
	}

	if(!filter_var($isUniqueEmail, FILTER_VALIDATE_EMAIL) && !str_contains(".ac.id", $isUniqueEmail)) {
		echo "<script>alert('not valid email');</script>";
		return false;
	}

	$stmt->execute([
		$id,
		$data['firstName'],
		$data['lastName'],
		$data['email'],
		password_hash($data['password'], PASSWORD_DEFAULT),
		$data['bio'],
		$gambar
	]);


	closeDB();

	return $stmt->rowCount();
}

function upload($data) {
	$nama = $data['name'];
	$tmpName = $data['tmp_name'];
	$err = $data['error'];

	if($err === 4) {
		echo "<script>alert('choose picture');</script>";
		return false;
	}

	$valid = ['png', 'jpeg', 'jpg'];
	$userEks = explode('.', $nama);
	$userEks = strtolower($userEks[count($userEks) - 1]);

	if(!in_array($userEks, $valid)) {
		echo "<script>alert('.png .jpg .jpeg only');</script>";
		return false;
	}

	$nama = uniqid() . ".$userEks";

	move_uploaded_file($tmpName, "img/$nama");

	return $nama;
}

function ubah($data, $id, $dataGambar) {
	$dbh = conn();
	$stmt = $dbh->prepare("UPDATE user SET
			firstName = ?,
			lastName = ?,
			email = ?,
			bio = ?,
			gambar = ?
			WHERE id = ?
		");

	if($dataGambar['error'] != 4) {
		$gambar = upload($dataGambar);
	} else {
		$gambar = $data["namaGambar"];
	}

	if(!$gambar) {
		return false;
	}

	$stmt->execute([
		$data['firstName'],
		$data['lastName'],
		$data['email'],
		$data['bio'],
		$gambar,
		$id
	]);

	return $stmt->rowCount();
}

function hapus($id) {
	$dbh = conn();
	$stmt = $dbh->prepare("DELETE FROM user WHERE id = ?");

	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function search($keyword) {
	$dbh = conn();
	$stmt = $dbh->prepare("SELECT * FROM user WHERE firstName LIKE :keyword OR lastName LIKE :keyword OR email LIKE :keyword OR bio LIKE :keyword");
	$key = "%$keyword%";
	$stmt->execute(['keyword' => $key]);

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 ?>