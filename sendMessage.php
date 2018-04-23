<?php
include('config.php');

	$sql = file_get_contents('sql/getEmployeeMessages.sql');
	$params = array(
		'employeeid' => $employee->getEmployeeid()
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$employeemessages = $statement->fetchAll(PDO::FETCH_ASSOC);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$action = $_POST['action'];
	$messagesid = $_POST['messagesid'];

	if($action == 'Send'){
		$sql = file_get_contents('sql/setMessageStatus.sql');
		$params = array(
			'messagesid' => $messagesid
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		header("Refresh:0");
		die();
	}
	elseif($action == 'Edit'){
		header("Location: submitMessage.php?action=edit&messagesid=".$messagesid);
		die();
	}
	elseif($action == 'Delete'){
		$sql = file_get_contents('sql/deleteMessage.sql');
		$params = array(
			'messagesid' => $messagesid
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		header("Refresh:0");
		die();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | Send A Message</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main>
	<h2>Send A Message to Human Resources</h2>
	<a href = "submitMessage.php?action=add">Compose a Message</a>
	<br>
	<h4>Your Drafts</h4>
	<?php foreach($employeemessages as $employeemessage) : ?>
		<div class="array">
			<strong>Message:</strong><br><?php echo $employeemessage['message'] ?><br><br>
			<form method="POST">
				<input type="submit" name="action" value="Send">
				<input type="submit" name="action" value="Edit">
				<input type="submit" name="action" value="Delete">
				<input type="hidden" name="messagesid" value="<?php echo $employeemessage['messagesid'] ?>">
			</form>
		</div>
	<?php endforeach; ?>
</main>
</body>
</html>