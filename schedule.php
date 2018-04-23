<?php
include('config.php');

	$sql = file_get_contents('sql/getEmployeeAbsence.sql');
	$params = array(
		'employeeid' => $employee->getEmployeeid()
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$employeeabsences = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | Schedule</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main style="padding-bottom:100px">
	<h2>Schedule Your Day Off</h2>
	<a href = "form.php?action=add">Add a Leave of Absence</a><br>
	<br>
	<h3>Your Current Leaves of Absences</h3>
	<?php foreach($employeeabsences as $employeeabsence) : ?>
		<div class="array">
			<strong>Start Date:</strong> <?php echo date("m-d-Y", strtotime($employeeabsence['start_date'])) ?><br>
			<strong>End Date:</strong> <?php echo date("m-d-Y", strtotime($employeeabsence['end_date']))?><br>
			<strong>Approval:</strong> <?php echo $employeeabsence['status']?><br>
			<?php if($employeeabsence['status'] = 'processing') : ?>
				<a href = "form.php?action=edit&employee_absencesid=<?php echo $employeeabsence['employee_absencesid']?>">Edit Leave of Absence</a>
			<?php endif ?>
			<br>
		</div>
	<?php endforeach; ?>	
</main>
</body>
</html>