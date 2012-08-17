<?php
App::uses('Day','Vendor');
App::uses('Week','Vendor');
class MyEmployee
{
	public $id;
	public $first_name;
	public $middle_name;
	public $last_name;
	public $user_group;
	public $group_id;
	public $department;
	public $department_id;
	public $employee_number;
	public $pto_remaining;
	public $sick_time_remaining;
	public $pay_cycle;
	public $position;
	public $extension;
	public $time_clock_remote_access;
	public $entry_type;
	public $week_one;
	public $week_two;
	public $my_weeks;
	public $two_week_total;
	public $two_week_over_time;
	public $two_week_sick_time;
	public $unapproved_times;
	public $two_week_work_codes;
	public $two_week_holiday_time ;
	public $two_week_vacation_time ;
	public $total_all_time;
	
    function __construct( $info_arr )
    {
    	
    	//these don't go in the cake employee class
    	$foreign_table_info_arr = array('user_group','department','unapproved_times','pay_periods',
    	'total_hours','over_time','times','week_one','week_two','my_weeks','two_week_total','two_week_over_time',
    	'two_week_sick_time','two_week_work_codes','two_week_holiday_time','two_week_vacation_time','total_all_time');
    	foreach( $this as $key => $value)
    	{
    		if ( in_array($key, $foreign_table_info_arr))
    		{
    			continue;
    		}
            else 
            {
    		    $this->$key = $info_arr['Employee'][$key];
            }
    	}
    	//debug($info_arr);
    	$this->user_group = $info_arr['Group']['group_name'];
    	$this->department = $info_arr['department']['department_name'];
    	$time_clock = new TimeClock();
        $pay_periods = EmployeesController::getPayPeriods();
        
        $conditions = array("employee_id" => $info_arr['Employee']['id'], "DATE(punch_in )  BETWEEN '". $pay_periods['week_one_start']->format("Y-m-d").
         "' AND '".$pay_periods['week_one_end']->format("Y-m-d")."'", 'approved' => 0,'deleted' => 0 );
    	$this->unapproved_times['week_one'] = $time_clock->find('count', array( 'conditions' => $conditions));
        $conditions = array("employee_id" => $info_arr['Employee']['id'], "DATE( punch_in )  BETWEEN '". $pay_periods['week_two_start']->format("Y-m-d").
         "' AND '".$pay_periods['week_two_end']->format("Y-m-d")."'", 'approved' => 0, 'deleted' => 0 );
    	$this->unapproved_times['week_two'] = $time_clock->find('count', array( 'conditions' => $conditions));  
    }
    

    public function setWeeks($week_one_start,$week_one_end,$week_two_start,$week_two_end)
    {
        for($x = 0;$x<=1; $x++ )
        {   
           if ($x == 0 )
           {
           	$this->week_one = new Week($week_one_start,$week_one_end, $this->id );
           }
           else 
           {
           	
           	$this->week_two = new Week($week_two_start,$week_two_end, $this->id );
           }
        }//endfor
       $this->my_weeks = array ( $this->week_one, $this->week_two );
       $arr = MyEmployee::secondsToTime( $this->week_one->regular_week_seconds + $this->week_two->regular_week_seconds);
       $this->two_week_total = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->over_time_seconds + $this->week_two->over_time_seconds );
       $this->two_week_over_time = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->sick_week_seconds + $this->week_two->sick_week_seconds);
       $this->two_week_total_sick_time = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->holiday_week_seconds + $this->week_two->holiday_week_seconds);
       $this->two_week_holiday_time = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->vacation_week_seconds + $this->week_two->vacation_week_seconds);
       $this->two_week_vacation_time = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->total_all_seconds + $this->week_two->total_all_seconds);
       $this->total_all_time = $arr['h'].":".$arr['m'];
       
    }
    public function getRemainingSick()
    {

     //get used sick time
     $sick_time = $this->sick_time_remaining;
     $time_clock = new TimeClock();
     $clocks = $time_clock->find('all', array('conditions' => array('Employee_id' => $this->id, 'work_code' => 'sick')));
     $sick_used_seconds = 0;
     foreach ( $clocks as $clock )
     {
       $punch = new Punch( $clock['TimeClock']['id'] );
       $sick_used_seconds += $punch->total_time_seconds;
     } 
     $sick_time_remaining = $sick_time - $sick_used_seconds;
     
     $arr = MyEmployee::secondsToTime( $sick_time_remaining );
     return $arr['h'].":".$arr['m'];    	
    	
    } 
    public function getRemainingVacation()
    {
     $pto = $this->pto_remaining;
     $time_clock = new TimeClock();
     $clocks = $time_clock->find('all', array('conditions' => array('Employee_id' => $this->id, 'work_code' => 'vacation')));
     $vacation_used_seconds = 0;
     foreach ( $clocks as $clock )
     {
       $punch = new Punch( $clock['TimeClock']['id'] );
       $vacation_used_seconds += $punch->total_time_seconds;
     }
     $vacation_remaining = $pto - $vacation_used_seconds;
     $arr = MyEmployee::secondsToTime( $vacation_remaining );
     return  $arr['h'].":".$arr['m'];  	
    	
    }    
    public static function secondsToTime($seconds)
     {
	// extract hours
	$hours = floor($seconds / (60 * 60));

	// extract minutes
	$divisor_for_minutes = $seconds % (60 * 60);
	$minutes = floor($divisor_for_minutes / 60);

	// extract the remaining seconds
	$divisor_for_seconds = $divisor_for_minutes % 60;
	$seconds = ceil($divisor_for_seconds);

	// return the final array
	$obj = array(
		"h" => (int) $hours,
		"m" => sprintf("%02d", $minutes),
		"s" => (int) $seconds,
	);
	return $obj;
    }   
    
}   

?>