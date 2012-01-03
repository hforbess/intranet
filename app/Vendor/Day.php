<?php
App::uses('TimeClock','Model');
class Day 
{
	var $my_date;
	var $punches;
	var $daily_hours;
	var $day_of_week;
	var $employee_id;
	var $daily_seconds;
	var $unapproved;
	var $uses = array('Department','Employee','TimeClock','DebugKit' );
	function __construct($my_date,$employee_id)
	{
	    $this->employee_id = $employee_id;
	 
	    $this->my_date = $my_date;

		$this->day_of_week = $my_date->format("l");
       
        $clock = new TimeClock();
		$this->punches = $clock->find('all',array('conditions' => 
		                  array('employee_id' => $employee_id,
		                  'punch_in >=' => $my_date->format('Y-m-d'),
		                  'punch_in <=' => $my_date->modify('+1 day')->format('Y-m-d')
		                 )));
        
         $this->daily_hours = 0;
         $this->daily_seconds = 0;
         $this->unapproved = 0;
		 foreach ($this->punches as $punch)
		 {   
	    	
		 	 $punch_in = new DateTime($punch['TimeClock']['punch_in']);
	    	 $punch_out = new DateTime($punch['TimeClock']['punch_out']);
	    	 $punch_in_unix = mktime( $punch_in->format("H"),$punch_in->format("i"),0,$punch_in->format("n"),$punch_in->format("j"),$punch_in->format("y"));
	    	 $punch_out_unix = mktime( $punch_out->format("H"),$punch_out->format("i"),0,$punch_out->format("n"),$punch_out->format("j"),$punch_out->format("y"));
	    	 $total_per_punch_seconds = $punch_out_unix - $punch_in_unix;

		     $this->daily_seconds +=  $total_per_punch_seconds;
		     if ( $punch['TimeClock']['approved']  == 0 )
		     {
		     	$this->unapproved++;
		     	
		     }
		    
		     $daily_hours = MyEmployee::secondsToTime( $this->daily_seconds );

		     $this->daily_hours = $daily_hours['h'].".".$daily_hours['m'] ;
		 }
	}
	

}
?>