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


    function __construct( $info_arr )
    {
    	$foreign_table_info_arr = array('user_group','department','unapproved_times','pay_periods',
    	'total_hours','over_time','times','week_one','week_two','my_weeks','two_week_total','two_week_over_time');
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
    	
    	$this->user_group = $info_arr['Group']['group_name'];
    	$this->department = $info_arr['department']['department_name'];
  
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
       
       $arr = MyEmployee::secondsToTime( $this->week_one->total_seconds + $this->week_two->total_seconds );
       $this->two_week_total = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->total_seconds + $this->week_two->total_seconds );
       $this->two_week_total = $arr['h'].":".$arr['m'];
       $arr = MyEmployee::secondsToTime( $this->week_one->over_time_seconds + $this->week_two->over_time_seconds );
       $this->two_week_over_time = $arr['h'].":".$arr['m'];
         
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