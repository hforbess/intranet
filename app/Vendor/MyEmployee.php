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


    function __construct( $info_arr )
    {
    	$foreign_table_info_arr = array('user_group','department','unapproved_times','pay_periods','total_hours','over_time','times','week_one','week_two','my_weeks');
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
		"m" => (int) $minutes,
		"s" => (int) $seconds,
	);
	return $obj;
    }   
    
}   

?>