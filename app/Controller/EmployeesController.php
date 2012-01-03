<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'MyEmployee');
App::import('Vendor', 'Day');


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
       $temp->setPayPeriod( $this->getPayPeriods() );
       $temp->setTimes($this->getHours($pay_periods['current_start'], $pay_periods['current_end'], $temp->id));
       $this->set('employee',$temp);

	}
	public function edit( $id = null ) {

       $emp =  $this->Employee->find( 'first',array( 'conditions' => array('Employee.id' => $id )));  
       $temp  = new MyEmployee($emp);
       $pay_periods = $this->getPayPeriods();

       $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
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
    
 $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
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
      $current_end = new DateTime( '2011-12-24');
      $current_start = new DateTime( '2011-12-11');
      //$current_end = clone $known_pay_period_end;
      //$current_start = clone $known_pay_period_end;
      $current_start->modify('+ 1 days');
      $current_start->modify('- 14 days');
      $week_one_start = clone $current_start;
      $week_one_end =  clone $current_start; 
      $week_one_end->modify('+ 7 days');
      $week_two_start = clone $week_one_end;

      $week_two_end = clone $week_two_start;
      $week_two_end->modify('+ 5 days');
      $prev_start = clone $current_start;
      $prev_end = clone $current_end;
      $prev_start = clone $prev_start->modify('- 14 days');
      $prev_end = clone $prev_end->modify('- 14 days');
      $week_one_start = new DateTime( '2011-12-11');
      $week_one_end = new DateTime( '2011-12-17');
      $week_two_start = new DateTime( '2011-12-18');
      $week_two_end = new DateTime( '2011-12-24');
      //$pay_periods = array( 'current_start' => $current_start,'current_end' => $current_end, 'prev_start' => $prev_start, 'prev_end' => $prev_end);
      $pay_periods = array('week_one_start' => $week_one_start, 'week_one_end' => $week_one_end, 'week_two_start' => $week_two_start, 'week_two_end' => $week_two_end);
      return $pay_periods;
      
   }
   

}
