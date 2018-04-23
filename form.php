<?php
include('config.php');

$action = $_GET['action'];

if(isset($_GET['employee_absencesid'])){
	$employee_absencesid = $_GET['employee_absencesid'];
}

$absence  = null;

if (!(empty($employee_absencesid))) {
	$sql = file_get_contents('sql/getAbsence.sql');
	$params = array(
		'employee_absencesid' => $employee_absencesid
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$absences = $statement->fetchAll(PDO::FETCH_ASSOC);
	$absence = $absences[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$reason = $_POST['reason'];
	$employeeid = $employee->getEmployeeid();

	if($action == 'add') {
		$sql = file_get_contents('sql/addAbsence.sql');
		$params = array(
			'reason' => $reason
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
		$absencesid = $database->lastInsertId();
		
		print_r($absencesid);
		
		$sql = file_get_contents('sql/addEmployeeAbsences.sql');
		$params = array(
			'employeeid' => $employeeid,
			'absencesid' => $absencesid,
			'start_date' => $startdate,
			'end_date' => $enddate
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
	}	
	elseif ($action == 'edit') {
		
		$absencesid = $absence['absencesid'];
		
		$sql = file_get_contents('sql/editAbsence.sql');
        $params = array( 
			'reason' => $reason,
			'absencesid' => $absencesid 
		);
        $statement = $database->prepare($sql);
        $statement->execute($params);
		
		$sql = file_get_contents('sql/editEmployeeAbsences.sql');
		$params = array(
			'employee_absencesid' => $employee_absencesid,
			'start_date' => $startdate,
			'end_date' => $enddate
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);		
    }
	
	header('location: schedule.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | Schedule Form</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main class="form">
	<h2>Absence Application</h2>
	<form method="POST">
		<label>Start Date</label><br>
		<?php if($action == 'add') : ?>
			<input type="date" name="startdate" />
		<?php else : ?>
			<input type="date" name="startdate" value = "<?php echo $absence['startdate'] ?>"/>
		<?php endif; ?>
		<br>
		<label>End Date</label><br>
		<?php if($action == 'add') : ?>
			<input type="date" name="enddate" />
		<?php else : ?>
			<input type="date" name="enddate" value = '<?php echo $absence['enddate'] ?>'/>
		<?php endif; ?>
		<br>
		<label>Reason</label><br><br>
		<?php if($action == 'add') : ?>
			<textarea name="reason" rows="10" cols="38"></textarea>
		<?php else : ?>
			<textarea name="reason" rows="10" cols="38"><?php echo $absence['reason'] ?></textarea>
		<?php endif; ?>
		<br>
		<input type="submit" class="button" />
		<input type="reset" class="button" />
		</form>	
</main>
</body>
</html>