<?php

$username = 'schwiegera1';
$password = 'xAnugA7H';

$database = new PDO('mysql:host=localhost;dbname=db_spring18_schwiegera1',$username,$password);

//function my_autoloader($class) {
//    include 'classes/class.' . $class . '.php';
//}

//spl_autoload_register('my_autoloader');

session_start();

include('class.Employee.php');

$current_url = basename($_SERVER['REQUEST_URI']);

if (!isset($_SESSION['employeeid']) && $current_url != 'login.php') {
	header("Location: login.php");
}

elseif (isset($_SESSION['employeeid'])) {
	$employee = new Employee($_SESSION['employeeid'],$database);
}