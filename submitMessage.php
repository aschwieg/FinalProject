<?php
include('config.php');

$action = $_GET['action'];

if(isset($_GET['messagesid'])){
	$messagesid = $_GET['messagesid'];
}

$messagesid;

if (!(empty($messagesid))) {
	$sql = file_get_contents('sql/getMessage.sql');
	$params = array(
		'messagesid' => $messagesid
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$messages = $statement->fetchAll(PDO::FETCH_ASSOC);
	$message = $messages[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$newMessage = $_POST['message'];
	$choice = $_POST['choice'];
	$employeeid = $employee->getEmployeeid();

	if($action == 'add'&& $choice == 'Save') {
		$sql = file_get_contents('sql/addMessage.sql');
		$params = array(
			'message' => $newMessage,
			'employeeid' => $employeeid 
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);		
	}
	if($action == 'add'&& $choice == 'Send') {
		$sql = file_get_contents('sql/sendMessage.sql');
		$params = array(
			'message' => $newMessage,
			'employeeid' => $employeeid 
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);		
	}
	elseif ($action == 'edit' && $choice == 'Save') {
		$sql = file_get_contents('sql/editMessage.sql');
        $params = array( 
			'message' => $message,
			'employeeid' => $employeeid 
		);
        $statement = $database->prepare($sql);
        $statement->execute($params);
    }
	elseif ($action == 'edit' && $choice == 'Send') {
		$sql = file_get_contents('sql/sendEditMessage.sql');
        $params = array( 
			'message' => $message,
			'employeeid' => $employeeid 
		);
        $statement = $database->prepare($sql);
        $statement->execute($params);
    }
	header('location: sendMessage.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | Message Form</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main class="form">
	<h2>Enter your message:</h2>
	<form method="POST">
		<label>Message</label><br>
		<?php if($action == 'add') : ?>
			<textarea name="message" rows="10" cols="38"></textarea>
		<?php else : ?>
			<textarea name="message" rows="10" cols="38"><?php echo $message['message'] ?></textarea>
		<?php endif; ?>
		<br>
		<input type="submit" name="choice" value="Send" />
		<input type="submit" name="choice" value="Save"/>
		<input type="reset" />
		</form>	
</main>
</body>
</html>