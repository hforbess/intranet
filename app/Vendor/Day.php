<?php
App::uses('TimeClock','Model');
class Day 
{
	public  $my_date;
	public $punches;
	public  $daily_hours;
	public  $day_of_week;
	public   $employee_id;
	 var $uses = array('Department','Employee','TimeClock','DebugKit' );
	function __construct($my_date,$employee_id)
	{
	    $this->employee_id = $employee_id;
	    $this->my_date = $my_date;
	   
		$this->day_of_week = $my_date->format("w");
        $clock = new TimeClock();
		$this->punches = $clock->find('all',array('conditions' => 
		                  array('employee_id' => $employee_id,
		                  'punch_in >=' => $my_date->format('Y-m-d'),
		                  'punch_out <=' => $my_date->format('Y-m-d'))));
         $this->daily_hours = 0;
		 foreach ($this->punches as $punch)
		 {
	    	 $punch_in = new DateTime($week[$x]['TimeClock']['punch_in']);
	    	 $punch_out = new DateTime($week[$x]['TimeClock']['punch_out']);
	    	 $punch_in_unix = mktime( $punch_in->format("H"),$punch_in->format("i"),0,$punch_in->format("n"),$punch_in->format("j"),$punch_in->format("y"));
	    	 $punch_out_unix = mktime( $punch_out->format("H"),$punch_out->format("i"),0,$punch_out->format("n"),$punch_out->format("j"),$punch_out->format("y"));
	    	 $total_per_punch_seconds = $punch_out_unix - $punch_in_unix;		 	
		     $this->daily_hours +=  MyEmployee::secondsToTime($total_per_punch_seconds);
		     echo $this->daily_hours;
		 }
	}
	

}
?>