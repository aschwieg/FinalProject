<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$sql = file_get_contents('sql/login.sql');
	$params = array(
		'username' => $username,
		'password' => $password
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	if(!empty($users)) {
		echo "user found";
		$user = $users[0];
		$_SESSION['employeeid'] = $user['employeeid'];
		header('location: index.php');
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>The Shell Company | Login</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<header>
	<h1>The Shell Company</h1>
</header>
<main>
<div id="login">
	<h2>Login</h2>
	<p>Please login</p>
	<form method="POST">
		<input type="text" name="username" placeholder="Username" /><br>
		<input type="password" name="password" placeholder="Password" /><br>
		<br>
		<input type="submit" value="Log In" />
	</form>
</div>
</main>
</body>
</html>