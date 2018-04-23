<?php
include('config.php');

if($employee->getPosition() != "hr"){
	header('location: index.php');
}

$sql = file_get_contents('sql/getSchedules.sql');
$statement = $database->prepare($sql);
$statement->execute();
$schedules = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$status = $_POST['status'];
	$absencesid = $_POST['absencesid'];
	
	$sql = file_get_contents('sql/setStatus.sql');
	$params = array(
		'status' => $status,
		'absencesid' => $absencesid
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	header("Refresh:0");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | Process</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main>
	<h2>Process Schedules</h2>
	<table style="width:100%;text-align:center;">
	<tr>
		<th>Name</th>
		<th>Reason</th> 
		<th>Start Date</th>
		<th>End Date</th>
		<th>Decision</th>
	</tr>
	<?php foreach($schedules as $schedule) : ?>
	<tr>
		<td><?php echo $schedule['firstname'] ?> <?php echo $schedule['lastname'] ?></td>
		<td><?php echo $schedule['reason'] ?></td> 
		<td><?php echo $schedule['start_date'] ?></td>
		<td><?php echo $schedule['end_date'] ?></td>
		<td><form method="POST">
			<input type="submit" name="status" value="approved">
			<input type="submit" name="status" value="denied">
			<input type="hidden" name="absencesid" value="<?php echo $schedule['absencesid'] ?>">
		</form></td>
	</tr>
	<?php endforeach ?>
	</table>
</main>
</body>
</html>