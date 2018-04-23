<header>
	<div id="logout">
		Welcome <?php echo $employee->printName() ?>,
		<br>
		<a href="logout.php" >Logout</a>
	</div>
	<div>
		<h1><img width="35px" height="35px" src="images/logo.png"> Off-Shore Banking</h1> 
	</div>
</header>
<nav style="padding-top:5px; padding-bottom:5px">
	<a href="index.php">Home</a> |
	<a href="schedule.php">Schedule</a> |
	<a href="sendMessage.php">Send A Message</a> |
	<?php if($employee->getPosition() == 'hr') : ?>
		<a href='process.php'>Process Forms</a> |
	<?php endif ?>
	<?php if($employee->getPosition() == 'hr' ) : ?>
		<a href='viewMessages.php'>View Messages</a> |
	<?php endif ?>
	<?php if($employee->getPosition() == 'hr' || $employee->getPosition() == 'supervisor') : ?>
		<a href='search.php'>Search</a>
	<?php endif ?>
</nav>