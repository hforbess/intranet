<?php

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
	public $unapproved_times;
	public $pay_periods;
	public $total_hours;
	public $over_time;
	public $times;

    function __construct( $info_arr )
    {
    	$foreign_table_info_arr = array('user_group','department','unapproved_times','pay_periods','total_hours','over_time','times');
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
    
    public function setPayPeriod($pay_periods)
    {
    	$this->pay_periods = $pay_periods;
    }
    
    public function setTimes($times)
    {
    	$this->times = $times;
    	$unapproved = 0;
    	$total_hours = 0;
    	$total_per_punch = 0;

    	for ( $x = 0; $x < count($times); $x++)
    	{
         ($times[$x]['TimeClock']['approved']) == 0 ?  $unapproved++ : "";
    	 $punch_in = new DateTime($times[$x]['TimeClock']['punch_in']);
    	 $punch_out = new DateTime($times[$x]['TimeClock']['punch_out']);
    	 $punch_in_unix = mktime( $punch_in->format("H"),$punch_in->format("i"),0,$punch_in->format("n"),$punch_in->format("j"),$punch_in->format("y"));
    	 $punch_out_unix = mktime( $punch_out->format("H"),$punch_out->format("i"),0,$punch_out->format("n"),$punch_out->format("j"),$punch_out->format("y"));
    	 $total_per_punch_seconds = $punch_out_unix - $punch_in_unix;
    	 $times[$x]['TimeClock']['punch_total']  = $this->secondsToTime($total_per_punch_seconds);
         $total_hours += $total_per_punch_seconds;
        
    	}
    	
	    $forty_hours_in_seconds = 144000;
	    $this->over_time = 0;
	    if ( $total_hours > $forty_hours_in_seconds)
	    {

	    	$this->over_time = $total_hours - $forty_hours_in_seconds;
	        $total_hours = $forty_hours_in_seconds;
	    	
	    }
	
	    $this->total_hours = $total_hours;	
	    $this->unapproved_times = $unapproved ;
    }
    
    public function secondsToTime($seconds)
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