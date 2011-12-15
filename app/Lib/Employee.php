<?php
App::uses('Employee', 'Controller');
class Employee
{
	public $employee_id;
	public $first_name;
	public $middle_name;
	public $last_name;
	public $user_group;
	public $group_id;
	public $department;
	public $department_id;
	public $employee_number;
	public $pto_remaining;
	public $sick_time_remaning;
	public $pay_cycle;
	public $position;
	public $department_id;
	public $department;
	public $extension;
	public $time_clock_remote_access;
	public $entry_type;

    function __construct( $id )
    {
    	$emp = $this->Employee->find('all', array('conditions' => array( 'Employee.id' => id ) ));
    	foreach( $this as $key => $value)
    	{
    		$this->$$key = $emp['Employee'][$key];
    		
    	}
    	
    }
}
?>