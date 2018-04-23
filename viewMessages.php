<?php
include('config.php');

if($employee->getPosition() != "hr"){
	header('location: index.php');
}

$sql = file_get_contents('sql/getMessages.sql');
$statement = $database->prepare($sql);
$statement->execute();
$messages = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$messagesid = $_POST['messagesid'];
	
	$sql = file_get_contents('sql/setRead.sql');
	$params = array(
		'messagesid' => $messagesid
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	header("Refresh:0");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | View Messages</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main>
	<h2>Messages</h2>
	<?php foreach($messages as $message) : ?>
	<div class="array">
		<strong>Message:</strong><br>
		<?php echo $message['message'] ?><br><br>
		<form method="POST">
			<input type="submit" name="status" value="Mark Read">
			<input type="hidden" name="messagesid" value="<?php echo $message['messagesid'] ?>">
		</form>
	</div>
	<?php endforeach ?>
</main>
</body>
</html>