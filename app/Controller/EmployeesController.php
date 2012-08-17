<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'MyEmployee');
App::import('Vendor', 'Day');
App::uses('EditSupplemental', 'Model');


/**
 * Employees Controller
 *
 */

class EmployeesController extends AppController {
	public $helpers = array('Html', 'Form', 'Hours');
	
    var $uses = array('Department','Employee','TimeClock','DebugKit','EditSupplemental' );
    
	public function index() {

		$departments = $this->Department->find('all',array('order' => array('Department.department_id ASC')));
		//$employees = $this->Employee->find('all',array( 'order' => array('Employee.last_name ASC')));
		$this->set( 'departments',$departments );
		$this->render('index',false);
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
       $this->set('user', $emp['Group']['group_name']);
       $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
       $this->set('employee',$temp);


	}	
   public function getEmployeesByDepartment( $dept = null )
   {
    
   	
   	//use a different layout if a report
   	 $report = false; 
   	 if ( $this->params['url']['type'] == 'report' )
   	 {
   	  $report = true;
   	 }
   	$pay_periods = $this->getPayPeriods();

   	  $employees = $this->Employee->find('all',array('conditions' => array('Employee.department_id' => $dept ,'active' => 1)));
      foreach ( $employees as $emp)
      {
      // I made my own employee class. I hate those arrays.
       $temp  = new MyEmployee($emp);
    
      $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
      $emp_arr[] = $temp;
      }

      $this->set('my_employees',$emp_arr); 
      $my_render  = '/Elements/get_employees_by_department';
      if ( $report )
      {
       $my_render = '/Elements/get_employees_by_department_report';
      }
      $this->render( $my_render ,false);
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
   public function addSupplemental()
   {
      $arr = $this->params['pass'];
      $this->EditSupplemental->set("staff_id", $arr[0]);
      $this->EditSupplemental->set( "type", $arr[1] );
      $this->EditSupplemental->set("amount", $arr[2] );
      $this->EditSupplemental->set("date", $arr[3]);
      $this->EditSupplemental->save();
      $my_json = $this->supplementalSum($arr[0]);
      $json_arr = json_decode( $my_json );
      $new_total = $json_arr['Total'];
      $data = array ( "new_total" => $new_total, "id" =>$this->EditSupplemental->id,"type" => $arr[1],"amount" => $arr[2], "date" => $arr[3], "staff_id" => $arr[0] );
      $this->set('data',$data);
      $this->render('/Elements/add_supplemental',false);  
      
   }
   public function deleteSupplemental()
   {
      $arr = $this->params['pass'];
      $supplemental = New EditSupplemental();
      $supplemental->read(null,$arr[0]);
      $supplemental->set("deleted", 1);
      $supplemental->save();
      $my_json = $this->supplementalSum($arr[0]);
      $arr = json_decode( $my_json );
      $new_total = $arr['Total'];
      $this->autoRender = false;      
      return  $new_total;

      
   }
  public function supplemental($id )
  {
       $emp =  $this->Employee->find( 'first',array( 'conditions' => array('Employee.id' => $id )));  
       $temp  = new MyEmployee($emp);
       $pay_periods = $this->getPayPeriods();       
       $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
       $this->set('employee',$temp);
       $this->render('supplemental',false);  
  
  }
     
 public function supplementalIndex(){
 	$arr = $this->params['pass'];
 	$employee_id = $arr[0];
 	$this->set('employee_id', $employee_id);
    $emp =  $this->Employee->find( 'first',array( 'conditions' => array('Employee.id' => $employee_id )));  
    $temp  = new MyEmployee($emp);
    $this->set('employee',$temp );
 	$pay_periods = $this->getPayPeriods();
 	$start = $pay_periods['week_one_start']->format("Y-m-d");
 	$end = $pay_periods['week_two_end']->format("Y-m-d");
 	$this->set('pay_period_end',$end);
 	$conditions = array("staff_id" => $employee_id, "deleted" => 0 );
    $this->set('supplemental',$this->EditSupplemental->find("all", array( 'conditions' => $conditions)));
    $temp_arr  =  $this->supplementalSum($employee_id);
    //$temp_arr = json_decode( $json_arr);
    $this->set('supplemental_total',$temp_arr['Total'] );
    $this->render('supplemental',false);  
  
 }
 public function supplementalSum( $staff_id )
 {
  	
   	 $pay_periods = $this->getPayPeriods();
     $mySupplemental = New EditSupplemental();
     $conditions = array("staff_id" => $staff_id, "deleted" => 0 ," date BETWEEN '". $pay_periods['week_one_end']->format("Y-m-d"). "' AND '".$pay_periods['week_two_end']->format("Y-m-d")."'"); 
	 //$fields = array(' SUM(amount) as total ');
     $data = $mySupplemental->find('all',array('conditions' => $conditions));
     $seperate_totals = array('Mileage'=> 0 ,'Phone' => 0,'Foreman' => 0,'Commission' => 0 ,'Total' => 0 );

    foreach($data as $entry )
    {
    	switch( $entry['EditSupplemental']['type'])
       {
      	case 'Mileage':
      		$seperate_totals['Mileage'] += $entry['EditSupplemental']['amount'];
      		$seperate_totals['Total'] += $entry['EditSupplemental']['amount'];
      		break;
      	case 'Phone':
      		$seperate_totals['Phone'] += $entry['EditSupplemental']['amount'];
      		$seperate_totals['Total'] += $entry['EditSupplemental']['amount'];
      		break;
      	case 'Foreman':
      		$seperate_totals['Foreman'] += $entry['EditSupplemental']['amount'];
      		$seperate_totals['Total'] += $entry['EditSupplemental']['amount'];
      		break;
      	case 'Commission':
      		$seperate_totals['Commission'] += $entry['EditSupplemental']['amount'];
      		$seperate_totals['Total'] += $entry['EditSupplemental']['amount'];
      		break;
      	default;
      } 
    }
     $this->autoRender = false;
     return $seperate_totals;
 }
 
 public function isAuthorized()
 {

    return true;
 }
 public function accordion_home()
 {
        $this->render('accordion_home',false); 
   
 }
 public function accordion_forms()
 {
 
       $this->render('accordion_forms',false);  
 }
}
