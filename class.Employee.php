<?php

class Employee	{
	private $employeeid;
	private $firstname;
	private $lastname;
	private $position;
	private $database;

	function __construct($employeeid, $database)	{	
		$sql = file_get_contents('sql/getEmployee.sql');
		$params = array(
			'employeeid' => $employeeid
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		$employees = $statement->fetchAll(PDO::FETCH_ASSOC);
	
		$employee = $employees[0];
	
		$this->employeeid = $employee['employeeid'];
		$this->firstname = $employee['firstname'];
		$this->lastname = $employee['lastname'];
		$this->position = $employee['position'];
		$this->database = $database;
	}
	
	function printName(){
		echo $this->firstname . " " . $this->lastname;
	}
	
	function getPosition(){
		return $this->position;
	}
	
	function getEmployeeid(){
		return $this->employeeid;
	}


}

?>