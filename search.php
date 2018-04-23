<?php
include('config.php');

if($employee->getPosition() == "associate" ){
	header('location: index.php');
}

if(isset($_GET['search-term'])){
	$term = $_GET['search-term'];
	$sql = file_get_contents('sql/searchAbsences.sql');
	$params = array(
		'term' => $term
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$searches = $statement->fetchAll(PDO::FETCH_ASSOC);
}
else{
	$searches = array();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shell Company | Search</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
</head> 
<body>
<?php include('header.php'); ?>
<main style="padding-bottom:100px">
	<h2>Search</h2>
	<form method="GET">
		<input type="text" name="search-term" placeholder="Search..." />
		<input type="submit" />
	</form>
	<br>
	<?php foreach($searches as $search) : ?>
		<div class="array">	
			<strong>First Name:</strong><br>
			<?php echo $search['firstname']; ?><br>
			<strong>Lastname:</strong><br>
			<?php echo $search['lastname']; ?> <br>
			<strong>Start Date:</strong><br>
			<?php echo date("m-d-Y", strtotime($search['start_date'])) ?> <br>
			<strong>End Date:</strong><br>
			<?php echo date("m-d-Y", strtotime($search['end_date'])) ?> <br>
		</div>
	<?php endforeach; ?>
	
</main>
</body>
</html>