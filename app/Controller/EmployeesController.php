<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'MyEmployee');


/**
 * Employees Controller
 *
 */

class EmployeesController extends AppController {
	public $helpers = array('Html', 'Form', 'Hours');
	
    var $uses = array('Department','Employee','TimeClock','DebugKit' );



	public function index() {

		$departments = $this->Department->find('all',array('order' => array('Department.department_id ASC')));
		//$employees = $this->Employee->find('all',array( 'order' => array('Employee.last_name ASC')));
		$this->set( 'departments',$departments );
	}
	
	public function view( $id = null ) {

       $emp =  $this->Employee->find( 'first',array( 'conditions' => array('Employee.id' => $id )));  
       $temp  = new MyEmployee($emp);
       $pay_periods = $this->getPayPeriods();
       $temp->setPayPeriod($pay_periods);
       $temp->setTimes($this->getHours($pay_periods['current_start'], $pay_periods['current_end'], $temp->id));
       $this->set('employee',$temp);

	}
	
   public function getEmployeesByDepartment( $dept = null )
   {
      $pay_periods = $this->getPayPeriods();
   	  $employees = $this->Employee->find('all',array('conditions' => array('Employee.department_id' => $dept)));
      foreach ( $employees as $emp)
      {
      // I made my own employee class. I hate those arrays.
       $temp  = new MyEmployee($emp);
       $temp->setPayPeriod($pay_periods);
       $temp->setTimes($this->getHours($pay_periods['current_start'], $pay_periods['current_end'], $temp->id));
       $emp_arr[] = $temp;
      
      }
      $this->set('my_employees',$emp_arr); 
     
      $this->render('/Elements/get_employees_by_department',false);
   }

   public function getPayPeriods()
   {
     $today = new DateTime('today');
     //pick an end of a pay period to calculate off of
     $known_pay_period_start =  new DateTime('2011-11-27');
     $known_pay_period_end =  new DateTime('2011-11-26');
     //calculate until the end of a pay period is greater than today
      while(  $known_pay_period_end < $today )
      {
       $known_pay_period_end->modify('+ 14 days');
      }
      $current_end = clone $known_pay_period_end;
      $current_start = clone $known_pay_period_end->modify('- 14 days');
      $prev_start = clone $current_start->modify('- 14 days');
      $prev_end = clone $current_end->modify('- 14 days');
      return $pay_periods = array( 'current_start' => $current_start,'current_end' => $current_end, 'prev_start' => $prev_start, 'prev_end' => $prev_end);

   }
   
   public function getHours($start, $end, $employee_id)
   {
   
     return  $this->TimeClock->find('all',
     array('conditions' => array('employee_id'=> $employee_id, 
               'punch_in >=' => $start->format('Y-m-d'),
               'punch_in <=' => $end->format('Y-m-d')),
           'order' => array('punch_in ASC')));
   }
}
